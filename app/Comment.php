<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable =  ['title', 'body', 'rating'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function restaurant()
    {
        return $this->belongsTo('App\Restaurant');
    }
}
