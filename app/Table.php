<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    public $timestamps = false;

    public function restaurant()
    {
        return $this->belongsTo('App\Restaurant');
    }

    public function order()
    {
        return $this->hasMany('App\Order');
    }
}
