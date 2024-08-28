<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class City extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'cities';

    protected $fillable = [
        'name',
        'zipCode',
        'country',
    ];
}
