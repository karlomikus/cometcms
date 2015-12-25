<?php
namespace Comet\Transformers;

use League\Fractal\TransformerAbstract;

class GameTransformer extends TransformerAbstract
{
    public function transform($game)
    {
        return [
            'id'    => (int) $game->id,
            'text'  => $game->name,
            'code'  => $game->code,
            'image' => $game->image
        ];
    }
}