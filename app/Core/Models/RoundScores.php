<?php
namespace Comet\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Comet\RoundScores
 *
 * @property integer $id 
 * @property integer $round_id 
 * @property integer $home 
 * @property integer $guest 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property \Carbon\Carbon $deleted_at 
 * @method static \Illuminate\Database\Query\Builder|\Comet\RoundScores whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\RoundScores whereRoundId($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\RoundScores whereHome($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\RoundScores whereGuest($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\RoundScores whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\RoundScores whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\RoundScores whereDeletedAt($value)
 */
class RoundScores extends Model {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $hidden = ['created_at', 'updated_at'];

    protected $guarded = ['id'];
    
}