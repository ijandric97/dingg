<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function table()
    {
        return $this->belongsTo('App\Table');
    }

    // ERROR: INVESTIGATE, THIS MAY BE REDUNDANT TBH
    public function restaurant()
    {
        return $this->belongsTo('App\Restaurant');
    }

    public function products()
    {
        return $this->belongsToMany('App\Product');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
