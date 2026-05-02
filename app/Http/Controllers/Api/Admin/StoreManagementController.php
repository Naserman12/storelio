<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;

class StoreManagementController extends Controller
{
    public function index()
    {
        return response()->json(Store::with('owner')->latest()->get());
    }

    public function toggle($id)
    {
        $store = Store::findOrFail($id);

        $store->update([
            'is_active' => !$store->is_active
        ]);

        return response()->json([
            'message' => 'Store status updated',
            'store' => $store
        ]);
    }
}