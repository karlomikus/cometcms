<?php
namespace Comet\Http\Controllers\Admin;

use Creitive\Breadcrumbs\Breadcrumbs;
use Comet\Http\Controllers\Controller;
use Comet\Services\AlertsService as Alerts;

/**
 * Base admin controller
 * @package Comet\Http\Controllers\Admin
 */
class AdminController extends Controller
{
    /**
     * @var Alerts Alerts instance
     */
    protected $alerts;

    /**
     * @var \Comet\User|null Currently logged in user
     */
    protected $currentUser;

    protected $breadcrumbs;

    /**
     * Initialize alerts and setup current user
     */
    public function __construct()
    {
        \Debugbar::enable();
        // Alerts
        $this->alerts = new Alerts();

        // Current user
        $this->currentUser = \Auth::user();

        // Breadcrumbs
        $this->breadcrumbs = new Breadcrumbs;
        $this->breadcrumbs->addCrumb('Dashboard', '/admin');
        $this->breadcrumbs->setDivider('');
        view()->share('breadcrumbs', $this->breadcrumbs);
    }
}
