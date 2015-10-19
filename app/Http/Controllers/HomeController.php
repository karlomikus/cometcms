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
		echo "Theme: " . $this->theme->get();
		return view('home');
	}

}
