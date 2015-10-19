<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Repositories\Contracts\MatchesRepositoryInterface;
use App\Http\Controllers\Local\LocalController;

class MatchesController extends LocalController {

    protected $matches;

    public function __construct(MatchesRepositoryInterface $matches)
    {
        parent::__construct();

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