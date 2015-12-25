<?php
namespace Comet\Core\Transformers;

use League\Fractal\TransformerAbstract;

class TeamHistoryTransformer extends TransformerAbstract
{
    public function transform($userHistory)
    {

        return [
            'userId'     => (int) $userHistory->user_id,
            'firstName'  => $userHistory->first_name,
            'lastName'   => $userHistory->last_name,
            'position'   => $userHistory->position,
            'status'     => $userHistory->status,
            'captain'    => (bool) $userHistory->captain,
            'replacedOn' => $userHistory->replaced
        ];
    }
}