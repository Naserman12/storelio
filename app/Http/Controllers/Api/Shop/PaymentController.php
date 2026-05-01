<?php

namespace App\Http\Controllers\Api\Shop;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    // 🟢 إنشاء عملية دفع
    public function pay(Request $request, $orderId)
    {
        $request->validate([
            'method' => 'required|in:cod,bank,card'
        ]);

        $order = Order::where('user_id', auth()->id())
            ->findOrFail($orderId);

        if ($order->status !== 'pending') {
            return response()->json([
                'message' => 'Order already processed'
            ], 400);
        }

        // إنشاء الدفع
        $payment = Payment::create([
            'order_id' => $order->id,
            'store_id' => $order->store_id,
            'amount' => $order->total,
            'method' => $request->method,
            'status' => $request->method === 'cod' ? 'pending' : 'paid',
            'transaction_id' => Str::uuid()
        ]);

        // تحديث الطلب
        if ($payment->status === 'paid') {
            $order->update([
                'status' => 'paid'
            ]);
        }

        return response()->json([
            'message' => 'Payment processed',
            'payment' => $payment
        ]);
    }

    // 🟢 عرض المدفوعات
    public function index()
    {
        $payments = Payment::whereHas('order', function ($q) {
            $q->where('user_id', auth()->id());
        })->latest()->get();

        return response()->json($payments);
    }
}