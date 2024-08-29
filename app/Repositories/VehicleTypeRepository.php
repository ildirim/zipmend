<?php

namespace App\Repositories;

use App\Models\VehicleType;
use Illuminate\Support\Collection;

class VehicleTypeRepository
{
    public function __construct(
        public VehicleType $vehicleType,
    )
    {
    }

    public function getAll(): Collection
    {
        return $this->vehicleType->all();
    }
}
