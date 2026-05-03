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

        // جلب الدومين الرئيسي من الإعدادات لاستثناءه
        $appUrl = parse_url(config('app.url'), PHP_URL_HOST);
        
        // ⛔ تخطي IdentifyStore للدومين الرئيسي أو البيئة المحلية
        $mainDomains = [$appUrl, 'localhost', '127.0.0.1', 'storelio-production.up.railway.app'];
        if (in_array($host, $mainDomains)) {
            return $next($request);
        }

        // ⛔ تخطي IdentifyStore لمسارات auth (أضفنا api/ لأنها مسارات API)
        if ($request->is('api/register') || $request->is('api/login') || $request->is('api/user')) {
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