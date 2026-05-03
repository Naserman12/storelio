<?php

use App\Http\Controllers\Api\Admin\AdminDashboardController;
use App\Http\Controllers\Api\Admin\OrderManagementController;
use App\Http\Controllers\Api\Admin\StoreManagementController;
use App\Http\Controllers\Api\Admin\UserManagementController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\StoreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Shop\CartController;
use App\Http\Controllers\Api\Shop\OrderController;
use App\Http\Controllers\Api\Shop\PaymentController;
use App\Http\Controllers\Api\Store\DashboardController;
use App\Http\Controllers\Api\Store\SettingController;
use App\Http\Controllers\Api\Store\ThemeController;

/*
|--------------------------------------------------------------------------
| API Routes - Storelio SaaS
|--------------------------------------------------------------------------
*/


// // 🔐 Auth Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/public/products', [ProductController::class, 'public']);
Route::get('/public/store', [StoreController::class, 'public']);
// Cart
Route::middleware(['auth:sanctum'])->group(function () {
    // User
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    // Orders
    Route::post('/orders', [OrderController::class, 'store']); // checkout
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);
    // Pay
   Route::post('/payments/{orderId}', [PaymentController::class, 'pay']);
    Route::get('/payments', [PaymentController::class, 'index']);

// Cart
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/add', [CartController::class, 'add']);
    Route::put('/cart/update/{id}', [CartController::class, 'update']);
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove']);
    Route::delete('/cart/clear', [CartController::class, 'clear']);

});
// Admin
Route::prefix('admin')
    ->middleware(['auth:sanctum', 'role:super_admin'])
    ->group(function () {
        
        Route::get('/dashboard', [AdminDashboardController::class, 'index']);

        Route::get('/stores', [StoreManagementController::class, 'index']);
        Route::patch('/stores/{id}/toggle', [StoreManagementController::class, 'toggle']);

        Route::get('/users', [UserManagementController::class, 'index']);

        Route::get('/orders', [OrderManagementController::class, 'index']);
    });

// // 👤 User (authenticated)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', fn (Request $request) => $request->user());
    Route::post('/logout', [AuthController::class, 'logout']);

    
        // 🏪 Store Owner Routes
    Route::middleware('role:owner')->group(function () {

    // Settings
    Route::get('/settings', [SettingController::class, 'index']);
    Route::post('/settings', [SettingController::class, 'set']);
    Route::delete('/settings/{key}', [SettingController::class, 'destroy']);
    // Themes
    Route::get('/theme', [ThemeController::class, 'show']);
    Route::post('/theme', [ThemeController::class, 'update']);
            // Stors
            Route::get('/stores', [StoreController::class, 'show']);
            Route::post('/stores', [StoreController::class, 'store']);
    
            // Products
             Route::apiResource('products', ProductController::class);
            //  Categories
             Route::apiResource('categories', CategoryController::class);
            // Route::get('/products', [\App\Http\Controllers\Api\ProductController::class, 'index']);
            // Route::post('/products', [\App\Http\Controllers\Api\ProductController::class, 'store']);
            // Dashboard
            Route::get('/dashboard', [DashboardController::class, 'index']);
    
            // // Orders
            // Route::get('/orders', [\App\Http\Controllers\Api\OrderController::class, 'index']);
        });
});
