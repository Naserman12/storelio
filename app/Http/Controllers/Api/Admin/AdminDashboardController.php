<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return response()->json([
            'stores_count' => Store::count(),
            'users_count' => User::count(),
            'orders_count' => Order::count(),
            'products_count' => Product::count(),

            'total_sales' => Order::where('status', 'paid')->sum('total'),
        ]);
    }
}