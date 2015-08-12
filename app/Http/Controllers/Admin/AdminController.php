<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AlertsService as Alerts;

/**
 * Base admin controller
 * @package App\Http\Controllers\Admin
 */
class AdminController extends Controller {

    /**
     * @var Alerts Alerts instance
     */
    protected $alerts;

    /**
     * @var \App\User|null Currently logged in user
     */
    protected $currentUser;

    /**
     * Initialize alerts and setup current user
     */
    public function __construct()
    {
        $this->alerts = new Alerts();
        $this->currentUser = \Auth::user();
    }

} 