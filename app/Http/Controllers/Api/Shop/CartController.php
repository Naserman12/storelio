<?php

namespace App\Http\Controllers\Api\Shop;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Services\StoreService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // 🟢 عرض السلة
    public function index(Request $request)
    {
        $cart = Cart::with('items.product')
            ->where('user_id', auth()->id())
            ->first();

        return response()->json($cart);
    }

    // 🟢 إضافة منتج
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1'
        ]);

        $store = StoreService::current(); 

        // جلب أو إنشاء السلة
        $cart = Cart::firstOrCreate([
            'user_id' => auth()->id(),
            'store_id' => $store->id
        ]);

        // هل المنتج موجود؟
        $item = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($item) {
            $item->increment('quantity', $request->quantity ?? 1);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity ?? 1
            ]);
        }

        return response()->json([
            'message' => 'Added to cart'
        ]);
    }

    // 🟡 تحديث الكمية
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $item = CartItem::findOrFail($id);

        $item->update([
            'quantity' => $request->quantity
        ]);

        return response()->json([
            'message' => 'Updated'
        ]);
    }

    // 🔴 حذف عنصر
    public function remove($id)
    {
        $item = CartItem::findOrFail($id);
        $item->delete();

        return response()->json([
            'message' => 'Removed'
        ]);
    }

    // 🔴 حذف السلة بالكامل
    public function clear()
    {
        $cart = Cart::where('user_id', auth()->id())->first();

        if ($cart) {
            $cart->items()->delete();
        }

        return response()->json([
            'message' => 'Cart cleared'
        ]);
    }
}