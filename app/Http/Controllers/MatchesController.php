<?php namespace App\Http\Controllers;

use App\Game;
use App\Http\Requests;
use App\Opponent;
use App\Repositories\Contracts\MatchesRepositoryInterface;
use App\Team;

class MatchesController extends Controller {

    protected $matches;

    public function __construct(MatchesRepositoryInterface $matches)
    {
        $this->matches = $matches;
    }

	public function index()
    {
        $data['matches'] = $this->matches->all();

        return view('matches.info', $data);
    }

    public function show($id)
    {
        $data['match'] = $this->matches->get($id);

        return view('matches.details', $data);
    }

    public function create()
    {
        $data['teams'] = Team::all();
        $data['opponents'] = Opponent::all();
        $data['games'] = Game::all();

        return view('matches.form', $data);
    }

    public function save()
    {
        return redirect('/matches');
    }

    public function formData()
    {
        $data = [
            'teams' => Team::all(),
            'opponents' => Opponent::all(),
            'games' => Game::all()
        ];

        return response()->json($data);
    }

}