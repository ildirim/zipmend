<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use App\Http\Resources\VehicleResource;
use App\Services\TransportService;

class TransportController extends Controller
{
    public function __construct(public TransportService $transportService)
    {
    }

    public function calculatePriceForVehicles(AddressRequest $addressRequest)
    {
        $vehicleResources = $this->transportService->calculatePriceForVehicles($addressRequest);
        $response = VehicleResource::collection($vehicleResources);
        return response()->json($response);
    }
}
