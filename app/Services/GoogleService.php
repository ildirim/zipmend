<?php

namespace App\Services;

use App\Exceptions\DirectionApiException;
use App\Traits\HttpTrait;

class GoogleService
{
    use HttpTrait;

    public function getDirection(string $from, string $to)
    {
        try {
            $this->createClient('https://maps.googleapis.com/');
            $url = sprintf("maps/api/directions/json?destination=%s&origin=%s&key=%s", $from, $to, env('GOOGLE_KEY'));
            return $this->httpGet($url);
        } catch (\Exception $exception) {
            throw new DirectionApiException('Google Direction Api is not working');
        }
    }
}
