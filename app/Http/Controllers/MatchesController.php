<?php namespace App\Http\Controllers;

use App\Game;
use App\Http\Requests;
use App\Repositories\Contracts\GamesRepositoryInterface;
use App\Repositories\Contracts\MatchesRepositoryInterface;
use App\Repositories\Contracts\OpponentsRepositoryInterface;
use App\Repositories\Contracts\TeamsRepositoryInterface;

class MatchesController extends Controller {

    protected $matches;

    public function __construct(MatchesRepositoryInterface $matches)
    {
        $this->matches = $matches;
    }

	public function index()
    {
        $data['matches'] = $this->matches->all();

        return view('matches.main', $data);
    }

    public function show($id)
    {
        $data['match'] = $this->matches->get($id);

        return view('matches.details', $data);
    }

    public function create(TeamsRepositoryInterface $teams, OpponentsRepositoryInterface $opponents, GamesRepositoryInterface $games)
    {
        $data['teams'] = $teams->all();
        $data['opponents'] = $opponents->all();
        $data['games'] = $games->all();

        return view('matches.form', $data);
    }

    public function save()
    {
        return redirect('/matches');
    }

}