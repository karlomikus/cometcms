<?php
namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class TeamHistoryTransformer extends TransformerAbstract
{
    public function transform($userHistory)
    {
        return [
            'userId'     => (int) $userHistory->id,
            'name'       => $userHistory->name,
            'replacedOn' => $userHistory->replaced,
            'position'   => $userHistory->position,
            'captain'    => (bool) $userHistory->captain
        ];
    }
}