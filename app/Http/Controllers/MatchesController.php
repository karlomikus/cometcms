<?php namespace App\Http\Controllers;

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

        return view('matches.info', $data);
    }

    public function show($id)
    {
        $data['match'] = $this->matches->get($id);

        return view('matches.details', $data);
    }

    public function create()
    {
        return view('matches.form');
    }

    public function save()
    {
        return redirect('/matches');
    }

}