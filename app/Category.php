<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'description'];
    public $timestamps = false; // This model does not have timestamps, we dont need them

    public function restaurants()
    {
        return $this->belongsToMany("App\Restaurant");
    }

    // Check help doc on Eloquent: Mutators
    public function getCountAttribute()
    {
        return count($this->restaurants);
    }
}
