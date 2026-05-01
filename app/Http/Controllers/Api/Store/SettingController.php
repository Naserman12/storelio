<?php

namespace App\Http\Controllers\Api\Store;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\StoreService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    // 🟢 عرض كل الإعدادات
    public function index()
    {
        $store = StoreService::current(); 

        $settings = Setting::where('store_id', $store->id)->get();

        return response()->json($settings);
    }

    // 🟢 حفظ / تحديث إعداد
    public function set(Request $request)
    {
        $request->validate([
            'key' => 'required|string',
            'value' => 'nullable'
        ]);

        $store = StoreService::current(); 

        $setting = Setting::updateOrCreate(
            [
                'store_id' => $store->id,
                'key_name' => $request->key
            ],
            [
                'value' => $request->value
            ]
        );

        return response()->json([
            'message' => 'Saved',
            'setting' => $setting
        ]);
    }

    // 🔴 حذف إعداد
    public function destroy($key)
    {
        $store = StoreService::current(); 

        Setting::where('store_id', $store->id)
            ->where('key_name', $key)
            ->delete();

        return response()->json([
            'message' => 'Deleted'
        ]);
    }
}