<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    use SoftDeletes;

    public $timestamps = false;

    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = ['name', 'code', 'image'];

    protected $dates = ['deleted_at'];

    public function maps()
    {
        return $this->hasMany('App\Map');
    }

}
