<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Repositories\Contracts\MatchesRepositoryInterface', 'App\Repositories\MatchesRepository');
        $this->app->bind('App\Repositories\Contracts\TeamsRepositoryInterface', 'App\Repositories\TeamsRepository');
        $this->app->bind('App\Repositories\Contracts\OpponentsRepositoryInterface', 'App\Repositories\OpponentsRepository');
        $this->app->bind('App\Repositories\Contracts\GamesRepositoryInterface', 'App\Repositories\GamesRepository');
        $this->app->bind('App\Repositories\Contracts\UsersRepositoryInterface', 'App\Repositories\UsersRepository');
    }
}