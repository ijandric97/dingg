<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workhour extends Model
{
    public $timestamps = false;

    public function restaurant()
    {
        return $this->belongsTo('App\Restaurant');
    }
}
