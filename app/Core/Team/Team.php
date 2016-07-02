<?php
namespace Comet\Core\Team;

use Comet\Core\User\User;
use Comet\Core\Match\Match;
use Comet\Core\Team\Models\TeamBaseModel;

/**
 * Team
 *
 * @package Comet\Core\Team
 */
class Team extends TeamBaseModel
{
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
