<?php
namespace Comet\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    private $namespace = 'Comet\Core\Contracts\Repositories\\';

    private $repos = [
        'MatchesRepositoryInterface' => 'Comet\Core\Repositories\MatchesRepository',
        'TeamsRepositoryInterface' => 'Comet\Core\Repositories\TeamsRepository',
        'OpponentsRepositoryInterface' => 'Comet\Core\Repositories\OpponentsRepository',
        'GamesRepositoryInterface' => 'Comet\Core\Repositories\GamesRepository',
        'UsersRepositoryInterface' => 'Comet\Core\Repositories\UsersRepository',
        'RolesRepositoryInterface' => 'Comet\Core\Repositories\RolesRepository',
        'MapsRepositoryInterface' => 'Comet\Core\Repositories\MapsRepository',
        'PostsRepositoryInterface' => 'Comet\Core\Repositories\PostsRepository',
        'PostCategoriesRepositoryInterface' => 'Comet\Core\Repositories\PostCategoriesRepository',
        'CountriesRepositoryInterface' => 'Comet\Core\Repositories\CountriesRepository',
    ];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->repos as $contract => $impl) {
            $this->app->bind($this->namespace . $contract, $impl);
        }
    }
}
