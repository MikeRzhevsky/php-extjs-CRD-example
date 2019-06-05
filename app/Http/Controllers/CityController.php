<?php

namespace App\Http\Controllers;

use App\Models\City;

class CityController extends Controller
{
    public function load()
    {
        $city = City::get()->toArray();
        //obfuscate
        return $city;//trim(json_encode($city),'[]');//response()->json($users,400);
        //return Response::jsend('success', $users); //Response::json('success', $users);
        //obfuscate
    }
}
