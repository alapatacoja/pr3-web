<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;

class OrderController extends Controller
{
    const ROBOT_CATEGORIES = ['bocata', 'bocata_especial', 'bocata_dia', 'bolleria', 'cafe', 'bebida'];
    const MENU_CATEGORIES  = ['menu_completo', 'menu_medio', 'menu_vegetariano', 'menu_saludable'];

    const MQTT_HOST = '127.0.0.1';  // broker en tu mismo PC
    const MQTT_PORT = 1883;

    public function index()   { return view('index'); }
    public function scanner() { return view('scanner'); }

    public function order($type)
    {
        $cats = $type === 'robot' ? self::ROBOT_CATEGORIES : self::MENU_CATEGORIES;
        $products = Product::whereIn('category', $cats)
                           ->where('available', true)
                           ->get()->groupBy('category');
        return view('order', compact('products', 'type'));
    }

    public function ticket($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
                      ->with('items.product')->firstOrFail();
        return view('ticket', compact('order'));
    }

    /* ── POST /checkout ── */
    public function checkout(Request $request)
    {
        $cartData    = json_decode($request->input('cart'), true);
        $type        = $request->input('type');
        $tableNumber = $request->input('table_number');

        if (empty($cartData)) {
            return redirect()->back()->with('error', 'El carrito está vacío.');
        }

        $orderType = 'robot';
        if ($type === 'menu') {
            $orderType = ($tableNumber && is_numeric($tableNumber)) ? 'vip' : 'agv';
        }

        $ids      = array_column($cartData, 'id');
        $products = Product::whereIn('id', $ids)->get()->keyBy('id');

        $total = 0;
        foreach ($cartData as $item) {
            if (isset($products[$item['id']])) {
                $total += $products[$item['id']]->price * $item['qty'];
            }
        }

        do {
            $orderNumber = 'CAF-' . strtoupper(substr(uniqid(), -4));
        } while (Order::where('order_number', $orderNumber)->exists());

        $order = Order::create([
            'order_number' => $orderNumber,
            'type'         => $orderType,
            'table_number' => ($orderType === 'vip') ? (int)$tableNumber : null,
            'status'       => 'pending',
            'total_price'  => $total,
        ]);

        foreach ($cartData as $item) {
            if (!isset($products[$item['id']])) continue;
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $item['id'],
                'quantity'   => $item['qty'],
                'unit_price' => $products[$item['id']]->price,
            ]);
        }

        // AGV y VIP: publicar ahora (no necesitan QR)
        if ($orderType !== 'robot') {
            $this->publishToFlexsim($order, $cartData, $products);
            $order->status = 'preparing';
            $order->save();
        }
        // Robot: NO publicamos aquí, esperamos al escaneo del QR

        return redirect()->route('ticket', $order->order_number);
    }

    /* ── POST /api/scan-order — llamado desde el scanner QR ── */
    public function scan(Request $request)
    {
        $order = Order::with('items.product')
                      ->where('order_number', $request->input('token'))
                      ->first();

        if (!$order) {
            return response()->json(['message' => 'Pedido no encontrado'], 404);
        }

        if ($order->type !== 'robot') {
            return response()->json(['message' => 'Este pedido no es de robot'], 400);
        }

        if ($order->status !== 'pending') {
            return response()->json(['message' => 'Pedido ya procesado']);
        }

        // Ahora sí publicamos al robot
        $cartData = $order->items->map(fn($i) => [
            'id'  => $i->product_id,
            'qty' => $i->quantity,
        ])->toArray();

        $products = $order->items->mapWithKeys(fn($i) => [$i->product_id => $i->product]);

        $this->publishToFlexsim($order, $cartData, $products);

        $order->status = 'preparing';
        $order->save();

        return response()->json(['message' => 'Pedido enviado al robot']);
    }

    /* ── MQTT ── */
    private function publishToFlexsim(Order $order, array $cartData, $products)
    {
        $payload = json_encode([
            'order_number' => $order->order_number,
            'type'         => $order->type,            // robot | agv | vip
            'table_number' => $order->table_number,
            'items'        => array_map(function($item) use ($products) {
                $p = $products[$item['id']] ?? null;
                return [
                    'product'  => $p?->name     ?? '',
                    'category' => $p?->category ?? '',
                    'qty'      => $item['qty'],
                ];
            }, $cartData),
        ]);

        try {
            $mqtt = new MqttClient(self::MQTT_HOST, self::MQTT_PORT, 'laravel-' . uniqid());
            $mqtt->connect();
            $mqtt->publish('cafeteria/orders', $payload, 0);
            $mqtt->disconnect();
        } catch (\Exception $e) {
            \Log::error('MQTT error: ' . $e->getMessage());
        }
    }
}