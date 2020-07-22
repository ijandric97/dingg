<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $timestamps = false;

    public function group()
    {
        return $this->belongsTo('App\Group');
    }

    public function orders()
    {
        return $this->belongsToMany('App\Order');
    }
}
