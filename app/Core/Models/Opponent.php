<?php
namespace Comet\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Comet\Opponent
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $image
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\Comet\Opponent whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\Opponent whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\Opponent whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\Opponent whereImage($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\Opponent whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\Opponent whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\Opponent whereDeletedAt($value)
 */
class Opponent extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

	protected $fillable = ['name', 'description', 'image'];
    
    protected $hidden = ['created_at', 'updated_at'];
}
