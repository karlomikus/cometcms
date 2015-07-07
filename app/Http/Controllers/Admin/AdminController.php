<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Session;

class AdminController extends Controller {

    private $alerts = [];

    public function __construct()
    {
        //Session::flash('alerts', $this->alerts);
    }

} 