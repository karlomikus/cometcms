<?php namespace Comet\Http\Controllers;

use Comet\Http\Requests;
use Comet\Repositories\Contracts\MatchesRepositoryInterface;
use Comet\Http\Controllers\Local\LocalController;

class MatchesController extends LocalController
{
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
