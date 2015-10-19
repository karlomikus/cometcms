<?php
namespace App\Libraries\Theme;

use Illuminate\Support\ServiceProvider;

class ThemeServiceProvider extends ServiceProvider {

    public function register()
    {
//        $this->app->bindShared('view.finder', function($app)
//        {
//            $paths = $app['config']['view.paths'];
//            return new ThemeViewFinder($app['files'], $paths);
//        });

        $this->app->bind('theme', function($app) {
            return new Theme($app);
        });
    }
}