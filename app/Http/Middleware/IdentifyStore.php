<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Store;

class IdentifyStore
{
    public function handle(Request $request, Closure $next)
    {
        // example: store1.storelio.com
        $host = $request->getHost(); 
         // ⛔ تخطي IdentifyStore للدومين الرئيسي (Railway)
        if ($host === 'storelio-production.up.railway.app/api'  || $host === 'storelio-production.up.railway.app') {
            return $next($request);
        }

        // ⛔ تخطي IdentifyStore لمسارات auth
        if ($request->is('/register') || $request->is('/login')) {
            return $next($request);
        }
        
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