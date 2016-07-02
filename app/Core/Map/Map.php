<?php
namespace Comet\Core\Map;

use Comet\Core\Game\Game;
use Comet\Core\Common\EloquentModel;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Comet\Map
 *
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
