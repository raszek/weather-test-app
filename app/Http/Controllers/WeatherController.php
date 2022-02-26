<?php

namespace App\Http\Controllers;

use App\Modules\Country\CountryLoader;

class WeatherController extends Controller
{

    public function index()
    {
        $countryLoader = new CountryLoader();

        return view('weather-form', [
            'countries' => $countryLoader->list()
        ]);
    }
}
