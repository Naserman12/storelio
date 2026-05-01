<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\StoreService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    // 🟢 عرض جميع التصنيفات
    public function index()
    {
        $categories = Category::latest()->get();

        return response()->json($categories);
    }

    // 🟢 إنشاء تصنيف
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string'
        ]);

        $store = StoreService::current();

        $category = Category::create([
            'store_id' => $store->id,
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . rand(1000,9999),
        ]);

        return response()->json([
            'message' => 'Category created',
            'category' => $category
        ]);
    }

    // 🟢 عرض تصنيف واحد
    public function show($id)
    {
        $category = Category::with('products')->findOrFail($id);

        return response()->json($category);
    }

    // 🟡 تحديث
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $category->update([
            'name' => $request->name ?? $category->name
        ]);

        return response()->json([
            'message' => 'Updated successfully',
            'category' => $category
        ]);
    }

    // 🔴 حذف
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json([
            'message' => 'Deleted successfully'
        ]);
    }
}