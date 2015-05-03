<?php
namespace App\Http\Controllers\Admin;

use App\Repositories\Contracts\GamesRepositoryInterface;
use App\Repositories\Contracts\TeamsRepositoryInterface;

class MatchesController extends AdminController {

    public function formData(TeamsRepositoryInterface $teams, GamesRepositoryInterface $games)
    {
        $data = [
            'teams' => $teams->all(),
            'games' => $games->all()
        ];
        return response()->json($data);
    }

} 