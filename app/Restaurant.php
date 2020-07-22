<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }

    public function owner()
    {
        return $this->belongsTo('App\User', 'id', 'owner_id');
    }

    public function workhours()
    {
        return $this->hasMany('App\Workhour');
    }

    public function tables()
    {
        return $this->hasMany('App\Table');
    }

    public function groups()
    {
        return $this->hasMany('App\Group');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
}
