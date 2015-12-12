<?php
namespace App\Transformers;

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
            'gameId'      => (int) $team->game_id,
            //'history'     => $team->history
        ];
    }

    public function includeRoster($team)
    {
        $roster = $team->roster;

        return $this->collection($roster, new TeamMembersTransformer());
    }
}