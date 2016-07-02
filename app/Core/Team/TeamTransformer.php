<?php
namespace Comet\Core\Team;

use League\Fractal\TransformerAbstract;

class TeamTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['roster'];

    public function transform($team)
    {
        return [
            'id'          => (int) $team->id,
            'name'        => $team->name,
            'description' => $team->description,
            'gameId'      => (int) $team->game_id
        ];
    }

    public function includeRoster($team)
    {
        $roster = $team->roster;

        return $this->collection($roster, new TeamMembersTransformer());
    }
}
