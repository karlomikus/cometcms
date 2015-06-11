<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Map
 *
 * @property integer $id 
 * @property string $name 
 * @property string $image 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @method static \Illuminate\Database\Query\Builder|\App\Map whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Map whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Map whereImage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Map whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Map whereUpdatedAt($value)
 */
class Map extends Model {

	protected $hidden = ['created_at', 'updated_at'];

    public function game()
    {
        return $this->belongsTo('App\Game');
    }

}
