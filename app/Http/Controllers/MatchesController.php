<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\MatchesRepository;

class MatchesController extends Controller {

    protected $matches;

    public function __construct(MatchesRepository $matches)
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

}