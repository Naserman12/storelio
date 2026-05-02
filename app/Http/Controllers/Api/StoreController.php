<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class StoreController extends Controller
{
    // 🟢 إنشاء متجر
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string'
        ]);

        $user = Auth::user();

        if ($user->role !== 'owner') {
            return response()->json([
                'message' => 'Only store owners can create stores'
            ], 403);
        }

        $store = Store::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . rand(1000,9999),
            'owner_id' => $user->id,
        ]);

        // ربط المستخدم بالمتجر
        // $user->update([
        //     'store_id' => $store->id
        // ]);

        return response()->json([
            'message' => 'Store created successfully',
            'store' => $store
        ]);
    }

    // User Store
    public function public()
    {
        return Store::first();
    }
    // 🟢 عرض المتجر الحالي
    public function show(Request $request)
    {
        return response()->json([
            'store' => $request->user()->store
        ]);
    }
}