<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class MatchRounds extends Model {

    public function scores()
    {
        return $this->hasMany('App\RoundScores', 'round_id');
    }

    public function map()
    {
        return $this->belongsTo('App\Map');
    }

}