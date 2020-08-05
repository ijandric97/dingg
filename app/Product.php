<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Scopes\DeletedScope;

class Product extends Model
{
    protected $fillable = ['name', 'description', 'price', 'discount', 'available'];

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

    public function group()
    {
        return $this->belongsTo('App\Group');
    }

    public function orders()
    {
        return $this->belongsToMany('App\Order');
    }

    public function restaurant()
    {
        return $this->belongsTo('App\Restaurant');
    }

    public function getCurrentPrice()
    {
        if ($this->discount <= 0) {
            return $this->price; // We are in the no dicount or negative discount??? return the normal price
        }
        if ($this->discount >= 100) {
            return 0; // We are over 100% discount, return 0
        }

        return round($this->price - ($this->price * ($this->discount/100)), 2);
    }
}
