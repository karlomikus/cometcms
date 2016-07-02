<?php
namespace Comet\Core\Game;

use Comet\Core\Map\Map;
use Comet\Core\Common\EloquentModel;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Comet\Game
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property string $image
 * @property \Carbon\Carbon $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Comet\Map[] $maps
 * @method static \Illuminate\Database\Query\Builder|\Comet\Game whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\Game whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\Game whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\Game whereImage($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\Game whereDeletedAt($value)
 */
class Game extends EloquentModel
{
    use SoftDeletes;

    public $timestamps = false;

    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = ['name', 'code', 'image'];

    protected $dates = ['deleted_at'];

    public function maps()
    {
        return $this->hasMany(Map::class);
    }
}
