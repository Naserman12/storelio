<?php

namespace App\Http\Controllers\Api\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Services\StoreService;

class ThemeController extends Controller
{
    // 🟢 عرض الثيم الحالي
    public function show()
    {
        return response()->json([
            'store_name' => setting('store_name'),
            'theme' => setting('theme') ?? 'default'
        ]);
    }

    // 🟢 تغيير الثيم
    public function update(Request $request)
    {
        $request->validate([
            'theme' => 'required|in:default,modern,dark,minimal'
        ]);

        $store = StoreService::current();

        Setting::updateOrCreate(
            [
                'store_id' => $store->id,
                'key_name' => 'theme'
            ],
            [
                'value' => $request->theme
            ]
        );

        return response()->json([
            'message' => 'Theme updated successfully',
            'theme' => $request->theme
        ]);
    }
}