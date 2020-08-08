<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Scopes\DeletedScope;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new DeletedScope);
    }

    public function ownedRestaurants()
    {
        return $this->hasMany('App\Restaurant', 'owner_id', 'id');
    }

    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function favorites()
    {
        return $this->belongsToMany('App\Restaurant', 'favorites');
    }

    public function requests()
    {
        return $this->hasMany('App\Request');
    }

    public function toggleFavorite(Restaurant $restaurant)
    {
        $this->favorites()->where('restaurant_id', $restaurant->id)->first() ?
        $this->favorites()->detach($restaurant) :
        $this->favorites()->attach($restaurant);
    }
}
