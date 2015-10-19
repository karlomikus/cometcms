<?php
namespace App\Http\Controllers\Local;

use App\Http\Controllers\Controller;

/**
 * Base public controller
 *
 * @package App\Http\Controllers\Public
 */
class LocalController extends Controller {

    /**
     * @var \App\User|null Currently logged in user
     */
    protected $currentUser;

    /**
     * Initialize alerts and setup current user
     */
    public function __construct()
    {
        $this->currentUser = \Auth::user();
    }

}