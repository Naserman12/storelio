<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['store_id','key_name','value'];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
