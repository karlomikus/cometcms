<?php
namespace Comet\Core\Team;

use Comet\Core\Match\Match;
use Comet\Core\User\User;
use Comet\Core\Common\EloquentModel;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Team
 *
 * @package Comet\Core\Team
 */
class Team extends EloquentModel
{
    use SoftDeletes;

    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = ['name', 'description', 'image', 'game_id'];

    protected $dates = ['deleted_at'];

    protected $with = ['roster'];

    public function roster()
    {
        return $this->belongsToMany(User::class, 'team_roster')
                ->whereNull('team_roster.deleted_at')
                ->withPivot('position', 'captain', 'status', 'id');
    }

    public function matches()
    {
        return $this->hasMany(Match::class);
    }
}
