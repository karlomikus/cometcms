<?php
namespace Comet\Core\Country;

use Comet\Core\Country\Country;
use Comet\Core\Common\EloquentRepository;
use Comet\Core\Contracts\Repositories\CountriesRepositoryInterface;

/**
 * Countries Repository
 *
 * @package Comet\Core\Country
 */
class CountriesRepository extends EloquentRepository implements CountriesRepositoryInterface
{
    public function __construct(Country $country)
    {
        parent::__construct($country);
    }
}
