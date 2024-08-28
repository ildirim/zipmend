<?php

namespace App\Helpers;

class CommonHelper
{
    public static function getFloatFromString(string $string): float
    {
        return preg_replace('/[^0-9\.]/', "", $string);
    }
}
