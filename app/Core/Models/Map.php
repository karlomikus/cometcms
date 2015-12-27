<?php
namespace Comet\Core\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Comet\Map
 *
 * @property integer $id
 * @property string $name
 * @property string $image
 * @property integer $game_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \Comet\Game $game
 * @method static \Illuminate\Database\Query\Builder|\Comet\Map whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\Map whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\Map whereImage($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\Map whereGameId($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\Map whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\Map whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\Map whereDeletedAt($value)
 */
class Map extends EloquentModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

	protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = ['name', 'image', 'game_id'];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}
