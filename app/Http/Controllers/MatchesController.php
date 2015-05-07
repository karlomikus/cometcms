<?php namespace App\Http\Controllers;

use App\Game;
use App\Http\Requests;
use App\Repositories\Contracts\MatchesRepositoryInterface;

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

    public function save()
    {
        return redirect('/matches');
    }

}