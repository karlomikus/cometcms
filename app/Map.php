<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Map
 *
 * @property integer $id 
 * @property string $name 
 * @property string $image 
 * @property integer $game_id 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property \Carbon\Carbon $deleted_at 
 * @property-read \App\Game $game 
 * @method static \Illuminate\Database\Query\Builder|\App\Map whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Map whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Map whereImage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Map whereGameId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Map whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Map whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Map whereDeletedAt($value)
 */
class Map extends Model {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

	protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = ['name', 'image', 'game_id'];

    public function game()
    {
        return $this->belongsTo('App\Game');
    }

}
