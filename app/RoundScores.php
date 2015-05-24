<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\RoundScores
 *
 * @property integer $id 
 * @property integer $round_id 
 * @property integer $score_home 
 * @property integer $score_guest 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @method static \Illuminate\Database\Query\Builder|\App\RoundScores whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RoundScores whereRoundId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RoundScores whereScoreHome($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RoundScores whereScoreGuest($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RoundScores whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RoundScores whereUpdatedAt($value)
 */
class RoundScores extends Model {

    protected $hidden = ['created_at', 'updated_at'];
    protected $guarded = ['id'];
    
}