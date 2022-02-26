<?php

namespace App\Http\Controllers;

use App\Modules\Country\CountryLoader;
use App\Rules\ValidCountry;
use Illuminate\Http\Request;

class WeatherController extends Controller
{

    public function __construct(
        private CountryLoader $countryLoader
    ) {
    }

    public function index(Request $request)
    {
        if ($request->method() === Request::METHOD_POST) {
            $this->store($request);
        }

        return view('weather-form', [
            'countries' => $this->countryLoader->list()
        ]);
    }

    private function store(Request $request)
    {
        $request->validate([
            'country' => ['required', new ValidCountry()],
            'city' => ['required']
        ]);
    }

}
