<?php

namespace App\Services;

use App\Helpers\CommonHelper;
use App\Http\Requests\AddressRequest;
use App\Http\Resources\VehicleResource;
use App\Models\City;
use App\Models\VehicleType;

class TransportService
{
    public function __construct(
        public GoogleService $googleService,
        public City $city,
        public VehicleType $vehicleType,
    )
    {
    }

    public function calculatePriceForVehicles(AddressRequest $addressRequest): array
    {
        $sumOfDistance = $this->getSumOfDistance($addressRequest);

        $vehicleTypes = $this->vehicleType->all();
        return $this->getVehicleResources($vehicleTypes, $sumOfDistance);
    }

    public function getSumOfDistance(AddressRequest $addressRequest): float
    {
        $sumOfDistance = 0;
        $addresses = $addressRequest->addresses;
        foreach ($addresses as $index => $address) {
            if ($index == 0) {
                continue;
            }
            $distance = $this->googleService->getDirection($address['city'], $addresses[$index - 1]['city'])->routes[0]->legs[0]->distance->text;
            $sumOfDistance += CommonHelper::getFloatFromString($distance);
        }
        return $sumOfDistance;
    }

    public function getVehicleResources($vehicleTypes, float $sum): array
    {
        $vehicleResources = [];
        foreach ($vehicleTypes as $vehicleType) {
            $vehicleResources[] = [
                'vehicle_type' => $vehicleType->number,
                'price' => $vehicleType->cost_km * $sum
            ];
        }
        return $vehicleResources;
    }
}
