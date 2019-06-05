<?php

namespace App\Http\Controllers;

use App\Models\City;

class CityController extends Controller
{
    public function load()
    {
        $city = City::get()->toArray();
        return $city;
    }
}
