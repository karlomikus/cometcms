<?php
namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform($user)
    {
        return [
            'id'        => (int) $user->id,
            'firstName' => $user->profile->first_name,
            'lastName'  => $user->profile->last_name,
            'bio'       => $user->profile->bio,
            'username'  => $user->username,
            'email'     => $user->email,
            'image'     => $user->profile->image
        ];
    }
}