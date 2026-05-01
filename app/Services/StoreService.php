<?php 
namespace App\Services;

class StoreService
{
    public static function current()
    {
        if (!app()->bound('current_store')) {
            abort(403, 'No store context');
        }

        return app('current_store');
    }
}