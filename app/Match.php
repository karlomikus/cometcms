<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Match extends Model {

    public function opponent()
    {
        return $this->belongsTo('App\Opponent');
    }

    public function team()
    {
        return $this->belongsTo('App\Team');
    }

    public function rounds()
    {
        return $this->hasMany('App\MatchRounds');
    }

    public function game()
    {
        return $this->belongsTo('App\Game');
    }

}