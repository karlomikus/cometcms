<?php
namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class TeamMembersTransformer extends TransformerAbstract
{
    public function transform($member)
    {
        return [
            'id'        => $member->pivot->id, // Team roster ID
            'userId'    => (int) $member->id,
            'firstName' => $member->profile->first_name,
            'lastName'  => $member->profile->last_name,
            'image'     => $member->image,
            'status'    => $member->pivot->status,
            'position'  => $member->pivot->position,
            'captain'   => (bool) $member->pivot->captain
        ];
    }
}