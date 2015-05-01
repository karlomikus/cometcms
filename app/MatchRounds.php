<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\MatchRounds
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\RoundScores[] $scores
 * @property-read \App\Map $map
 * @property integer $id 
 * @property integer $match_id 
 * @property integer $map_id 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @method static \Illuminate\Database\Query\Builder|\App\MatchRounds whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MatchRounds whereMatchId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MatchRounds whereMapId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MatchRounds whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MatchRounds whereUpdatedAt($value)
 */
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