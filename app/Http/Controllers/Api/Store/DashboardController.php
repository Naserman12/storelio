<?php

namespace App\Http\Controllers\Api\Store;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Services\StoreService;

class DashboardController extends Controller
{
    public function index()
    {
         $store = StoreService::current();
        // 📦 عدد المنتجات
        $productsCount = Product::where('store_id', $store->id)->count();

        // 🧾 عدد الطلبات
        $ordersCount = Order::where('store_id', $store->id)->count();

        // 💰 إجمالي المبيعات
        $totalSales = Order::where('store_id', $store->id)
            ->where('status', 'paid')
            ->sum('total');

        // 👥 العملاء (تقريبًا)
        $customersCount = Order::where('store_id', $store->id)
            ->distinct('user_id')
            ->count('user_id');

        // 🆕 آخر الطلبات
        $latestOrders = Order::where('store_id', $store->id)
            ->latest()
            ->take(5)
            ->get();
        // ارباح
        $profit = Order::where('store_id', $store->id)
        ->where('status', 'paid')
        ->sum('total');
        // طلبات اليوم
        $todayOrders = Order::where('store_id', $store->id)
         ->whereDate('created_at', today())
         ->count();
        //  مبيعات الشهر
        $monthlySales = Order::where('store_id', $store->id)
        ->whereMonth('created_at', now()->month)
        ->sum('total');
        return response()->json([
            'products_count' => $productsCount,
            'orders_count' => $ordersCount,
            'total_sales' => $totalSales,
            'customers_count' => $customersCount,
            'latest_orders' => $latestOrders,
            'monthly_sales' => $monthlySales,
            'today_orders' => $todayOrders,
            'profit' => $profit,

            
        ]);
    }
}