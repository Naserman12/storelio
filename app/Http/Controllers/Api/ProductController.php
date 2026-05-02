<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Services\StoreService;
use Illuminate\Support\Facades\Storage;

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
                'image' => 'nullable|image|max:2048',
                ]);
                
                $store = StoreService::current(); 
                if (!$store) {
                    return response()->json([
                        'message' => 'Store not found for this user'
                        ], 400);
                        }
             $data = $request->only([
                'category_id',
                'name',
                'description',
                'price',
                'quantity',
            ]);
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image'] = $path;
        }
                // 🖼️ رفع الصورة
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        // 🔗 slug
        $data['slug'] = Str::slug($request->name) . '-' . rand(1000,9999);

        // 🏪 store_id
        $data['store_id'] = $store->id;
        $product = Product::create($data);
        // $product = Product::create([
        //     'store_id' => $store->id,
        //     'category_id' => $request->category_id,
        //     'name' => $request->name,
        //     'image' => $data['image'] ?? null,
        //     'slug' => Str::slug($request->name) . '-' . rand(1000,9999),
        //     'description' => $request->description,
        //     'price' => $request->price,
        //     'quantity' => $request->quantity,
        // ]);

        return response()->json([
            'message' => 'Product created',
            'product' => $product,
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

            $data = $request->only([
                'name',
                'price',
                'quantity',
                'description',
                'category_id'
            ]);

            // 🖼️ معالجة الصورة
            if ($request->hasFile('image')) {

                // حذف القديمة (اختياري)
                if ($product->image && Storage::disk('public')->exists($product->image)) {
                    Storage::disk('public')->delete($product->image);
                }

                $path = $request->file('image')->store('products', 'public');
                $data['image'] = $path;
            }

            $product->update($data);

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