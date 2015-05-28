<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Game
 *
 * @property integer $id 
 * @property string $name 
 * @property string $code 
 * @property string $image
 * @method static \Illuminate\Database\Query\Builder|\App\Game whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Game whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Game whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Game whereImage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Game whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Game whereUpdatedAt($value)
 */
class Game extends Model {

    public $timestamps = false;
    protected $hidden = ['created_at', 'updated_at'];

    public function maps()
    {
        return $this->hasMany('App\Map');
    }

}
