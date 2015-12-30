<?php
namespace Comet\Core\Repositories;

use Comet\Core\Models\Country;
use Comet\Core\Contracts\Repositories\CountriesRepositoryInterface;

class CountriesRepository extends EloquentRepository implements CountriesRepositoryInterface
{
    public function __construct(Country $country)
    {
        parent::__construct($country);
    }
}