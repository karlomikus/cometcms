<?php
namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class TeamHistoryTransformer extends TransformerAbstract
{
    public function transform($team)
    {
        return [
            'id'          => (int) $team->id,
            'name'        => $team->name,
            'description' => $team->description,
            'gameId'      => (int) $team->game_id
        ];
    }
}