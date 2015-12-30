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
        $this->app->bind('Comet\Core\Contracts\Repositories\MatchesRepositoryInterface', 'Comet\Core\Repositories\MatchesRepository');
        $this->app->bind('Comet\Core\Contracts\Repositories\TeamsRepositoryInterface', 'Comet\Core\Repositories\TeamsRepository');
        $this->app->bind('Comet\Core\Contracts\Repositories\OpponentsRepositoryInterface', 'Comet\Core\Repositories\OpponentsRepository');
        $this->app->bind('Comet\Core\Contracts\Repositories\GamesRepositoryInterface', 'Comet\Core\Repositories\GamesRepository');
        $this->app->bind('Comet\Core\Contracts\Repositories\UsersRepositoryInterface', 'Comet\Core\Repositories\UsersRepository');
        $this->app->bind('Comet\Core\Contracts\Repositories\RolesRepositoryInterface', 'Comet\Core\Repositories\RolesRepository');
        $this->app->bind('Comet\Core\Contracts\Repositories\MapsRepositoryInterface', 'Comet\Core\Repositories\MapsRepository');
        $this->app->bind('Comet\Core\Contracts\Repositories\PostsRepositoryInterface', 'Comet\Core\Repositories\PostsRepository');
        $this->app->bind('Comet\Core\Contracts\Repositories\PostCategoriesRepositoryInterface', 'Comet\Core\Repositories\PostCategoriesRepository');
        $this->app->bind('Comet\Core\Contracts\Repositories\CountriesRepositoryInterface', 'Comet\Core\Repositories\CountriesRepository');
    }
}