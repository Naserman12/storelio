<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Services\StoreService;

class ProductController extends Controller
{
    // 🟢 عرض المنتجات
    public function index(Request $request)
    {
        $query = Product::query();
            if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        return response()->json(
            $query->latest()->paginate(10)
        );
            
        }
        
        // 🟢 إنشاء منتج
        public function store(Request $request)
        {
            $request->validate([
                'category_id' => 'nullable|exists:categories,id',
                'name' => 'required|string',
                'price' => 'required|numeric',
                'quantity' => 'required|integer',
                ]);
                
        $store = StoreService::current(); // 👈 مهم

        $product = Product::create([
            'store_id' => $store->id,
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . rand(1000,9999),
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
        ]);

        return response()->json([
            'message' => 'Product created',
            'product' => $product
        ]);
    }

    // 🟢 عرض منتج واحد
    public function show($id)
    {
        $product = Product::findOrFail($id);

        return response()->json($product);
    }

    // 🟡 تحديث
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $product->update($request->only([
            'name','price','quantity','description'
        ]));

        return response()->json([
            'message' => 'Updated successfully',
            'product' => $product
        ]);
    }

    // 🔴 حذف
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json([
            'message' => 'Deleted successfully'
        ]);
    }
}