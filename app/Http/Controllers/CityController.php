<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Models\City;

class CityController extends Controller
{
    public function index($state_id)
    {
        $cities = State::find($state_id)
            ->cities()
            ->orderBy('description', 'ASC')
            ->get();

        return json_decode($cities, true);
    }

    public function byName($stateId, $cityName) {
        $city = City::where('description', $cityName)
            ->where('state_id', $stateId)
            ->firstOrFail();

        return json_decode($city, true);
    }
}
