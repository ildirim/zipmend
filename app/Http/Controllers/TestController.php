<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\VehicleType;
use App\Traits\HttpTrait;
use Illuminate\Http\Request;

class TestController extends Controller
{
    use HttpTrait;
    public function index()
    {
        $this->createClient('https://maps.googleapis.com/');
        $a = $this->httpGet('maps/api/directions/json?destination=Montreal&origin=Toronto&key=AIzaSyA_z4H4vBv0Mn8og2T4c2_iWqJrfiLAIqY');
        dd($a, VehicleType::first(), City::all());
    }
}
