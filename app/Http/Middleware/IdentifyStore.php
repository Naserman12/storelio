<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Store;

class IdentifyStore
{
    public function handle(Request $request, Closure $next)
    {
        $host = $request->getHost(); 
        // example: store1.storelio.com

        $subdomain = explode('.', $host)[0];

        $store = Store::where('slug', $subdomain)->first();

        if (!$store) {
            abort(404, 'Store not found');
        }

        // نخزن المتجر في الطلب
        $request->merge(['current_store' => $store]);

        app()->instance('current_store', $store);

        return $next($request);
    }
}