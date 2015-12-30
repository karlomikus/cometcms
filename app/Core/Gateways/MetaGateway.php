<?php
namespace Comet\Core\Gateways;

use Comet\Core\Contracts\Repositories\GamesRepositoryInterface as Games;
use Comet\Core\Contracts\Repositories\CountriesRepositoryInterface as Countries;

class MetaGateway
{
    private $countries;
    private $games;

    public function __construct(Countries $countries, Games $games)
    {
        $this->countries = $countries;
        $this->games = $games;
    }

    public function getAllGames()
    {
        return $this->games->all();
    }

    public function getAllCountries()
    {
        return $this->countries->all();
    }
}