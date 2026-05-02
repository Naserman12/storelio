<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderManagementController extends Controller
{
    public function index()
    {
        return response()->json(
            Order::with('items')->latest()->get()
        );
    }
}