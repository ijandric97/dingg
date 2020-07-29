<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Scopes\DeletedScope;

class Table extends Model
{
    public $timestamps = false;

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new DeletedScope);
    }

    public function restaurant()
    {
        return $this->belongsTo('App\Restaurant');
    }

    public function order()
    {
        return $this->hasMany('App\Order');
    }
}
