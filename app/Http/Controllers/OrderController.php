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

    // Tipos numéricos para FlexSim
    const TYPE_VIP   = '1';
    const TYPE_AGV   = '2';
    const TYPE_ROBOT = '3';

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

        // Tipo numérico para FlexSim: 3=robot, 2=agv, 1=vip
        if ($type === 'robot') {
            $orderType = self::TYPE_ROBOT;
        } else {
            $orderType = ($tableNumber && is_numeric($tableNumber)) ? self::TYPE_VIP : self::TYPE_AGV;
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
            'table_number' => ($orderType === self::TYPE_VIP) ? (int)$tableNumber : null,
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

        // AGV (2) y VIP (1): quedan en pending, FlexSim los lee por DB
        // Robot (3): también pending, espera al escaneo del QR para pasar a preparing

        return redirect()->route('ticket', $order->order_number);
    }

    /* ── POST /api/scan-order ── */
    public function scan(Request $request)
    {
        $order = Order::with('items.product')
                      ->where('order_number', $request->input('token'))
                      ->first();

        if (!$order) {
            return response()->json(['message' => 'Pedido no encontrado'], 404);
        }

        if ($order->type !== self::TYPE_ROBOT) {
            return response()->json(['message' => 'Este pedido no es de robot'], 400);
        }

        if ($order->status !== 'pending') {
            return response()->json(['message' => 'Pedido ya procesado']);
        }

        $order->status = 'preparing';
        $order->save();

        return response()->json(['message' => 'Pedido enviado al robot']);
    }
}