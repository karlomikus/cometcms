<?php namespace Comet;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Comet\MatchRounds
 *
 * @property integer $id 
 * @property integer $match_id 
 * @property integer $map_id 
 * @property string $notes 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property \Carbon\Carbon $deleted_at 
 * @property-read \Illuminate\Database\Eloquent\Collection|\Comet\RoundScores[] $scores 
 * @property-read \Comet\Map $map 
 * @method static \Illuminate\Database\Query\Builder|\Comet\MatchRounds whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\MatchRounds whereMatchId($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\MatchRounds whereMapId($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\MatchRounds whereNotes($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\MatchRounds whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\MatchRounds whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\MatchRounds whereDeletedAt($value)
 */
class MatchRounds extends Model {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $hidden = ['created_at', 'updated_at'];
    
    protected $guarded = ['id'];

    public function scores()
    {
        return $this->hasMany('Comet\RoundScores', 'round_id');
    }

    public function map()
    {
        return $this->belongsTo('Comet\Map');
    }

}