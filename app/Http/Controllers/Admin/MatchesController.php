<?php
namespace App\Http\Controllers\Admin;

use App\Repositories\Contracts\GamesRepositoryInterface;
use App\Repositories\Contracts\MatchesRepositoryInterface;
use App\Repositories\Contracts\TeamsRepositoryInterface;

class MatchesController extends AdminController {

    protected $matches;

    public function __construct(MatchesRepositoryInterface $matches)
    {
        $this->matches = $matches;
    }

    public function index()
    {
        $data['matches'] = $this->matches->all();

        return view('admin.matches.index', $data);
    }

    public function formData(TeamsRepositoryInterface $teams, GamesRepositoryInterface $games)
    {
        $data = [
            'teams' => $teams->all(),
            'games' => $games->all()
        ];

        return response()->json($data);
    }

} 