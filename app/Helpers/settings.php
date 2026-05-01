<?php
use App\Models\Setting;
use App\Services\StoreService;

function setting($key)
{
    return Setting::where('store_id', StoreService::current()->id)
        ->where('key_name', $key)
        ->value('value');
}