<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\RoundScores
 *
 * @property integer $id 
 * @property integer $round_id 
 * @property integer $home 
 * @property integer $guest 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property \Carbon\Carbon $deleted_at 
 * @method static \Illuminate\Database\Query\Builder|\App\RoundScores whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RoundScores whereRoundId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RoundScores whereHome($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RoundScores whereGuest($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RoundScores whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RoundScores whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RoundScores whereDeletedAt($value)
 */
class RoundScores extends Model {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $hidden = ['created_at', 'updated_at'];

    protected $guarded = ['id'];
    
}