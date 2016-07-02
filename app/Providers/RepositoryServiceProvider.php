<?php
namespace Comet\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    private $namespace = 'Comet\Core\Contracts\Repositories\\';

    private $repos = [
        'MatchesRepositoryInterface'        => 'Comet\Core\Match\MatchesRepository',
        'TeamsRepositoryInterface'          => 'Comet\Core\Team\TeamsRepository',
        'OpponentsRepositoryInterface'      => 'Comet\Core\Opponent\OpponentsRepository',
        'GamesRepositoryInterface'          => 'Comet\Core\Game\GamesRepository',
        'UsersRepositoryInterface'          => 'Comet\Core\User\UsersRepository',
        'RolesRepositoryInterface'          => 'Comet\Core\Role\RolesRepository',
        'MapsRepositoryInterface'           => 'Comet\Core\Map\MapsRepository',
        'PostsRepositoryInterface'          => 'Comet\Core\Post\PostsRepository',
        'PostCategoriesRepositoryInterface' => 'Comet\Core\Post\PostCategoriesRepository',
        'CountriesRepositoryInterface'      => 'Comet\Core\Country\CountriesRepository',
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
