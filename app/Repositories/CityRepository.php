<?php

namespace App\Repositories;

use App\Models\City;

class CityRepository
{
    public function __construct(
        public City $city,
    )
    {
    }

    public function getCityByCountryAndZipCodeAndName(
        string $country,
        string $zipCode,
        string $name
    ): ?City
    {
        return $this->city
            ->where('zipCode', $zipCode)
            ->where('country', $country)
            ->where('name', $name)
            ->first();
    }
}
