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

    public function getCurrentPrice()
    {
        if ($this->discount <= 0) {
            return $this->price; // We are in the no dicount or negative discount??? return the normal price
        }
        if ($this->discount >= 1) {
            return 0; // We are over 100% discount, return 0
        }

        return $this->price - ($this->price * $this->discount);
    }
}
