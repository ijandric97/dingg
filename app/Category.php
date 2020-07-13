<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = false; // This model does not have timestamps, we dont need them

    public function restaurants() {
        return $this->belongsToMany("App\Restaurant");
    }
}
