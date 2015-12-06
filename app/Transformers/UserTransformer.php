<?php
namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform($user)
    {
        return [
            'id'       => (int) $user->id,
            'name'     => $user->name,
            'nickname' => $user->nickname,
            'email'    => $user->email,
            'image'    => $user->image
        ];
    }
}