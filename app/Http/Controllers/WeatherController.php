<?php

namespace App\Http\Controllers;

use App\Modules\Country\CountryLoader;
use App\Modules\Weather\WeatherModule;
use App\Rules\ValidCountry;
use Illuminate\Http\Request;

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
            $result = $this->getResult($request);
        }

        return view('weather-form', [
            'countries' => $this->countryLoader->list(),
            'result' => $result
        ]);
    }

    private function getResult(Request $request): array
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
            'temperature' => round($temperature)
        ];
    }

}
