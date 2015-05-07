<?php
namespace App\Http\Controllers\Admin;

use App\Repositories\Contracts\GamesRepositoryInterface;
use App\Repositories\Contracts\MatchesRepositoryInterface;
use App\Repositories\Contracts\TeamsRepositoryInterface;
use App\Repositories\Contracts\OpponentsRepositoryInterface;

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

    public function create(TeamsRepositoryInterface $teams, OpponentsRepositoryInterface $opponents, GamesRepositoryInterface $games)
    {
        $data['teams'] = $teams->all();
        $data['opponents'] = $opponents->all();
        $data['games'] = $games->all();

        return view('admin.matches.form', $data);
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