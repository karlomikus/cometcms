<?php
namespace App\Http\Controllers\Local;

use App\Http\Controllers\Controller;
use App\Libraries\Theme\Theme;

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
     * @var \App\Libraries\Theme\Theme Theme instance
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
        $this->theme->setTheme('foundation');
        stop_measure('theme_setup');
    }

}