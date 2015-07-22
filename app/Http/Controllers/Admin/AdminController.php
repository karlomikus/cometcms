<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Session;
use App\Services\AlertsService;

class AdminController extends Controller {

    protected $alerts;
    protected $currentUser;

    public function __construct()
    {
        $this->alerts = new AlertsService();
        $this->currentUser = \Auth::user();
    }

} 