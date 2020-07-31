<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Scopes\DeletedScope;


class Restaurant extends Model
{
    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new DeletedScope);
    }

    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }

    public function getCategoriesNameTable()
    {
        $categories = $this->categories()->orderBy('name', 'asc')->limit(3)->get();

        $categories_table = [
            ['name' => ''],
            ['name' => ''],
            ['name' => ''],
        ];

        $i = 0;
        foreach ($categories as $category) {
            $categories_table[$i] = ['name' => $category->name];
            $i = $i + 1;
        }

        return $categories_table;
    }

    public function owner()
    {
        return $this->belongsTo('App\User', 'id', 'owner_id');
    }

    public function workhours()
    {
        return $this->hasMany('App\Workhour');
    }

    /**
     * Returns a 2D array containing 7 elements with open_time and <close_time class=""></close_time>
     *
     * @return array [ ['open_time' => '00:00', 'close_time' '00:00'], ... ]
     */
    public function getWorkhoursTable()
    {
        $workhours = $this->workhours()->orderBy('day_of_week', 'asc')->get();

        $workhours_table = [
            ['day' => 'Monday', 'open_time' => '', 'close_time' => ''],
            ['day' => 'Tuesday', 'open_time' => '', 'close_time' => ''],
            ['day' => 'Wednesday', 'open_time' => '', 'close_time' => ''],
            ['day' => 'Thursday', 'open_time' => '', 'close_time' => ''],
            ['day' => 'Friday', 'open_time' => '', 'close_time' => ''],
            ['day' => 'Saturday', 'open_time' => '', 'close_time' => ''],
            ['day' => 'Sunday', 'open_time' => '', 'close_time' => ''],
        ];

        // FRONTEND WILL FAIL IF WE RETURN H:M:S format, so we return H:M format
        foreach ($workhours as $workhour) {
            $workhours_table[$workhour->day_of_week]['open_time'] = substr($workhour->open_time, 0, -3);
            $workhours_table[$workhour->day_of_week]['close_time'] = substr($workhour->close_time, 0, -3);
        }

        return $workhours_table;
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

    public function rating()
    {
        return round($this->comments()->avg('rating'), 1);
    }

    public function favorites()
    {
        return $this->belongsToMany('App\User', 'favorites');
    }

    public function products()
    {
        return $this->hasMany('App\Product');
    }
}
