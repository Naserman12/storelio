<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class StoreScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        // نتأكد أن المتجر الحالي موجود
        if (app()->has('current_store')) {
            $builder->where('store_id', app('current_store')->id);
        }
    }
}
