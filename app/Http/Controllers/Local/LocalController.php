<?php
namespace Comet\Http\Controllers\Local;

use Comet\Http\Controllers\Controller;
use Karlomikus\Theme\Theme;

/**
 * Base public controller
 *
 * @package Comet\Http\Controllers\Public
 */
class LocalController extends Controller {

    /**
     * @var \Comet\User|null Currently logged in user
     */
    protected $currentUser;

    /**
     * @var \Karlomikus\Theme\Theme Theme instance
     */
    protected $theme;

    /**
     * Initialize alerts and setup current user
     * @param Theme $theme
     */
    public function __construct(Theme $theme)
    {
        $this->middleware('auth');

        $this->currentUser = \Auth::user();
        $this->theme = $theme;

        start_measure('theme_setup','Time for theme setup');
        $this->theme->set('foundation');
        stop_measure('theme_setup');
    }

}