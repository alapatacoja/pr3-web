<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;

class OrderController extends Controller
{
    const ROBOT_CATEGORIES = ['bocata', 'bocata_especial', 'bocata_dia', 'bolleria', 'cafe', 'bebida'];
    const MENU_CATEGORIES  = ['menu_completo', 'menu_medio', 'menu_vegetariano', 'menu_saludable'];

    /* ── / ── */
    public function index()
    {
        return view('index');
    }

    /* ── /order/{type} ── */
    public function order($type)
    {
        if ($type === 'robot') {
            $products = Product::whereIn('category', self::ROBOT_CATEGORIES)
                               ->where('available', true)
                               ->orderByRaw("FIELD(category, 'bocata_especial','bocata_dia','bocata','bolleria','cafe','bebida')")
                               ->get()
                               ->groupBy('category');
        } else {
            $products = Product::whereIn('category', self::MENU_CATEGORIES)
                               ->where('available', true)
                               ->get()
                               ->groupBy('category');
        }

        return view('order', compact('products', 'type'));
    }

    /* ── POST /checkout ── */
    public function checkout(Request $request)
    {
        $cartData    = json_decode($request->input('cart'), true);
        $type        = $request->input('type');          // 'robot' o 'menu'
        $tableNumber = $request->input('table_number');

        if (empty($cartData)) {
            return redirect()->back()->with('error', 'El carrito está vacío.');
        }

        // Determinar tipo de pedido real
        $orderType = 'robot';
        if ($type === 'menu') {
            $orderType = ($tableNumber && is_numeric($tableNumber)) ? 'vip' : 'agv';
        }

        // Calcular total desde BD (no nos fiamos del precio del cliente)
        $ids      = array_column($cartData, 'id');
        $products = Product::whereIn('id', $ids)->get()->keyBy('id');

        $total = 0;
        foreach ($cartData as $item) {
            if (isset($products[$item['id']])) {
                $total += $products[$item['id']]->price * $item['qty'];
            }
        }

        // Generar número de pedido único: CAF-XXXX
        do {
            $orderNumber = 'CAF-' . strtoupper(substr(uniqid(), -4));
        } while (Order::where('order_number', $orderNumber)->exists());

        // Crear pedido
        $order = Order::create([
            'order_number' => $orderNumber,
            'type'         => $orderType,
            'table_number' => ($orderType === 'vip') ? (int)$tableNumber : null,
            'status'       => 'pending',
            'total_price'  => $total,
        ]);

        // Crear líneas
        foreach ($cartData as $item) {
            if (!isset($products[$item['id']])) continue;
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $item['id'],
                'quantity'   => $item['qty'],
                'unit_price' => $products[$item['id']]->price,
            ]);
        }

        // Publicar por MQTT (reutiliza tu código del año pasado)
        $this->publishMqtt($order, $cartData, $products);

        return redirect()->route('ticket', $order->order_number);
    }

    /* ── /ticket/{order_number} ── */
    public function ticket($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
                      ->with('items.product')
                      ->firstOrFail();

        return view('ticket', compact('order'));
    }

    /* ── MQTT ── */
    private function publishMqtt(Order $order, array $cartData, $products)
    {
        // Adapta aquí tu código de MQTT del año pasado (RoboDK → FlexSim)
        // El payload que esperará FlexSim:
        $payload = json_encode([
            'order_number' => $order->order_number,
            'type'         => $order->type,
            'table_number' => $order->table_number,
            'items'        => array_map(function($item) use ($products) {
                return [
                    'product'  => $products[$item['id']]->name ?? '',
                    'category' => $products[$item['id']]->category ?? '',
                    'qty'      => $item['qty'],
                ];
            }, $cartData),
        ]);

        // Ejemplo con php-mqtt/client (composer require php-mqtt/client):
        // $mqtt = new \PhpMqtt\Client\MqttClient('localhost', 1883, 'laravel-cafeteria');
        // $mqtt->connect();
        // $mqtt->publish('cafeteria/orders', $payload, 0);
        // $mqtt->disconnect();

        // O con tu librería del año pasado — solo cambia el topic y el payload
        \Log::info('MQTT payload: ' . $payload); // útil para debug mientras conectas FlexSim
    }
}
