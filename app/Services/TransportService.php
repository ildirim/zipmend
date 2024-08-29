<?php

namespace App\Services;

use App\Exceptions\CityNotFoundException;
use App\Exceptions\DirectionApiException;
use App\Http\Requests\AddressRequest;
use App\Http\Resources\VehicleResource;
use App\Repositories\CityRepository;
use App\Repositories\VehicleTypeRepository;

class TransportService
{
    public function __construct(
        public GoogleService         $googleService,
        public CityRepository        $cityRepository,
        public VehicleTypeRepository $vehicleTypeRepository,
    )
    {
    }

    public function calculatePriceForVehicles(AddressRequest $addressRequest): array
    {
        foreach ($addressRequest->addresses as $address) {
            $this->isValidCity($address);
        }

        $sumOfDistance = $this->getSumOfDistance($addressRequest);

        return $this->getVehicleResources($sumOfDistance);
    }

    public function isValidCity(array $address): void
    {
        $city = $this->cityRepository->getCityByCountryAndZipCodeAndName(
            $address['country'],
            $address['zip'],
            $address['city'],
        );
        if (!$city) {
            throw new CityNotFoundException('City not found');
        }
    }

    public function getSumOfDistance(AddressRequest $addressRequest): float
    {
        $sumOfDistance = 0;
        $addresses = $addressRequest->addresses;
        foreach ($addresses as $index => $address) {
            if ($index == 0) {
                continue;
            }
            $direction = $this->googleService->getDirection($address['city'], $addresses[$index - 1]['city']);
            if (!isset($direction->routes[0]->legs[0]->distance->value)) {
                throw new DirectionApiException('Google Direction Api is not working');
            }
            $distanceByMeters = $direction->routes[0]->legs[0]->distance->value;
            $distanceByMKM = $distanceByMeters / 1000;
            $sumOfDistance += $distanceByMKM;
        }
        return $sumOfDistance;
    }

    public function getVehicleResources(float $sumOfDistance): array
    {
        $vehicleTypes = $this->vehicleTypeRepository->getAll();

        $vehicleResources = [];
        foreach ($vehicleTypes as $vehicleType) {
            $price = $vehicleType->cost_km * $sumOfDistance;
            $vehicleResources[] = new VehicleResource([
                'vehicle_type' => $vehicleType->number,
                'price' => max($price, $vehicleType->minimum)
            ]);
        }
        return $vehicleResources;
    }
}
