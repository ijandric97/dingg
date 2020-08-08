<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function getStatus() {
        return ($this->status <= 0) ? 'Canceled' : ($this->status > 1 ? 'In progress' : 'Completed');
    }
}
