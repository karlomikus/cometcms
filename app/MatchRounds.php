<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\MatchRounds
 *
 * @property integer $id 
 * @property integer $match_id 
 * @property integer $map_id 
 * @property string $notes 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property \Carbon\Carbon $deleted_at 
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\RoundScores[] $scores 
 * @property-read \App\Map $map 
 * @method static \Illuminate\Database\Query\Builder|\App\MatchRounds whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MatchRounds whereMatchId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MatchRounds whereMapId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MatchRounds whereNotes($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MatchRounds whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MatchRounds whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MatchRounds whereDeletedAt($value)
 */
class MatchRounds extends Model {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $hidden = ['created_at', 'updated_at'];
    
    protected $guarded = ['id'];

    public function scores()
    {
        return $this->hasMany('App\RoundScores', 'round_id');
    }

    public function map()
    {
        return $this->belongsTo('App\Map');
    }

}