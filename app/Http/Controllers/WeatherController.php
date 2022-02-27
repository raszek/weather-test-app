<?php

namespace App\Http\Controllers;

use App\Modules\Country\CountryLoader;
use App\Modules\Weather\TemperatureNotFoundException;
use App\Modules\Weather\WeatherModule;
use App\Rules\ValidCountry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class WeatherController extends Controller
{

    public function __construct(
        private CountryLoader $countryLoader,
        private WeatherModule $weatherModule
    ) {
    }

    public function index(Request $request)
    {
        $result = null;

        if ($request->method() === Request::METHOD_POST) {
            try {
                $result = $this->getResult($request);
            } catch (TemperatureNotFoundException) {
                return Redirect::to('/')->withErrors([
                    'city' => 'City not found'
                ]);
            }
        }

        return view('weather-form', [
            'countries' => $this->countryLoader->list(),
            'result' => $result
        ]);
    }

    private function getResult(Request $request)
    {
        $city = $request->post('city');
        $countryCode = $request->post('country');

        $request->validate([
            'country' => ['required', new ValidCountry()],
            'city' => ['required']
        ]);

        $temperature = $this->weatherModule->getAverageTemperature(
            city: $city,
            countryCode: $countryCode
        );

        $country = collect($this->countryLoader->list())
            ->first(fn($ctr) => $ctr['code'] === $countryCode);

        return [
            'city' => $city,
            'countryName' => $country['name'] ?? $countryCode,
            'temperature' => round($temperature, 2)
        ];
    }

}
