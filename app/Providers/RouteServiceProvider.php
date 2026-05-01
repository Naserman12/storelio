<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Path to your application's "home"
     */
    public const HOME = '/home';

    public function boot(): void
    {
        $this->routes(function () {

            // 🌐 Web Routes
            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            // 🔌 API Routes
            Route::prefix('api')
                ->middleware('api')
                ->group(base_path('routes/api.php'));

            // (اختياري) Admin routes إذا توسعت لاحقًا
            // Route::prefix('admin')
            //     ->middleware(['web', 'auth'])
            //     ->group(base_path('routes/admin.php'));
        });
    }
}