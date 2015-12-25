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
        $this->app->bind('Comet\Core\Repositories\Contracts\MatchesRepositoryInterface', 'Comet\Core\Repositories\MatchesRepository');
        $this->app->bind('Comet\Core\Repositories\Contracts\TeamsRepositoryInterface', 'Comet\Core\Repositories\TeamsRepository');
        $this->app->bind('Comet\Core\Repositories\Contracts\OpponentsRepositoryInterface', 'Comet\Core\Repositories\OpponentsRepository');
        $this->app->bind('Comet\Core\Repositories\Contracts\GamesRepositoryInterface', 'Comet\Core\Repositories\GamesRepository');
        $this->app->bind('Comet\Core\Repositories\Contracts\UsersRepositoryInterface', 'Comet\Core\Repositories\UsersRepository');
        $this->app->bind('Comet\Core\Repositories\Contracts\RolesRepositoryInterface', 'Comet\Core\Repositories\RolesRepository');
        $this->app->bind('Comet\Core\Repositories\Contracts\MapsRepositoryInterface', 'Comet\Core\Repositories\MapsRepository');
        $this->app->bind('Comet\Core\Repositories\Contracts\PostsRepositoryInterface', 'Comet\Core\Repositories\PostsRepository');
        $this->app->bind('Comet\Core\Repositories\Contracts\PostCategoriesRepositoryInterface', 'Comet\Core\Repositories\PostCategoriesRepository');
    }
}