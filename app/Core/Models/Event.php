<?php
namespace Comet\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
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
