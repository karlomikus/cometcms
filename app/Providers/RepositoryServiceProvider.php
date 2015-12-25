<?php
namespace Comet\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Comet\Repositories\Contracts\MatchesRepositoryInterface', 'Comet\Repositories\MatchesRepository');
        $this->app->bind('Comet\Repositories\Contracts\TeamsRepositoryInterface', 'Comet\Repositories\TeamsRepository');
        $this->app->bind('Comet\Repositories\Contracts\OpponentsRepositoryInterface', 'Comet\Repositories\OpponentsRepository');
        $this->app->bind('Comet\Repositories\Contracts\GamesRepositoryInterface', 'Comet\Repositories\GamesRepository');
        $this->app->bind('Comet\Repositories\Contracts\UsersRepositoryInterface', 'Comet\Repositories\UsersRepository');
        $this->app->bind('Comet\Repositories\Contracts\RolesRepositoryInterface', 'Comet\Repositories\RolesRepository');
        $this->app->bind('Comet\Repositories\Contracts\MapsRepositoryInterface', 'Comet\Repositories\MapsRepository');
        $this->app->bind('Comet\Repositories\Contracts\PostsRepositoryInterface', 'Comet\Repositories\PostsRepository');
        $this->app->bind('Comet\Repositories\Contracts\PostCategoriesRepositoryInterface', 'Comet\Repositories\PostCategoriesRepository');
    }
}