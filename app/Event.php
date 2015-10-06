<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    public function game()
    {
        return $this->belongsTo('App\Game');
    }

    public function country()
    {
        return $this->belongsTo('App\Country');
    }
}
