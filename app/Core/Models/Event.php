<?php
namespace Comet\Core\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Comet\Core\Models\Event
 *
 * @property integer $id
 * @property string $name
 * @property string $date_start
 * @property string $date_end
 * @property string $description
 * @property string $image
 * @property integer $game_id
 * @property integer $country_id
 * @property string $location
 * @property string $prize
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property-read \Comet\Core\Models\Game $game
 * @property-read \Comet\Core\Models\Country $country
 */
class Event extends EloquentModel
{
    use SoftDeletes;

    protected $guarded = ['id'];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
