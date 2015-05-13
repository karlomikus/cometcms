<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Opponent
 *
 * @property integer $id 
 * @property string $name 
 * @property string $description 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @method static \Illuminate\Database\Query\Builder|\App\Opponent whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Opponent whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Opponent whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Opponent whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Opponent whereUpdatedAt($value)
 */
class Opponent extends Model {

	protected $fillable = ['name', 'description'];

}
