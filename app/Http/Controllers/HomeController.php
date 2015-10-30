<?php namespace App\Http\Controllers;

use App\Http\Controllers\Local\LocalController;

class HomeController extends LocalController {

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		echo $this->theme->get();
		theme_asset('asset');
		//dd($this->theme->getThemes());
		return view('home');
	}

}
