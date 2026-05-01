<?php

namespace App\Http\Controllers\Api\Shop;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\StoreService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // 🟢 إنشاء طلب (Checkout)
    public function store(Request $request)
    {
        $user = auth()->user();
        $store = StoreService::current(); 

        // جلب السلة
        $cart = Cart::with('items.product')
            ->where('user_id', $user->id)
            ->where('store_id', $store->id)
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return response()->json([
                'message' => 'Cart is empty'
            ], 400);
        }

        // حساب الإجمالي
        $total = 0;

        foreach ($cart->items as $item) {
            $total += $item->product->price * $item->quantity;
        }

        // إنشاء الطلب
        $order = Order::create([
            'store_id' => $store->id,
            'user_id' => $user->id,
            'total' => $total,
            'status' => 'pending',
            'payment_method' => $request->payment_method ?? 'cod'
        ]);

        // إضافة المنتجات
        foreach ($cart->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price
            ]);
        }

        // تفريغ السلة
        $cart->items()->delete();

        return response()->json([
            'message' => 'Order created successfully',
            'order' => $order
        ]);
    }

    // 🟢 عرض طلبات المستخدم
    public function index()
    {
        $orders = Order::with('items')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return response()->json($orders);
    }

    // 🟢 عرض طلب واحد
    public function show($id)
    {
        $order = Order::with('items')
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        return response()->json($order);
    }
}