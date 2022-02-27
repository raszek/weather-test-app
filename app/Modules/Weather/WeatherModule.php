<?php

namespace App\Modules\Weather;

use App\Modules\Weather\WeatherServices\OpenWeatherService;
use App\Modules\Weather\WeatherServices\WeatherService;

class WeatherModule
{

    public function __construct(
        private WeatherService $weatherService,
        private OpenWeatherService $openWeatherService
    ) {
    }

    public function getAverageTemperature(string $city, string $countryCode): float
    {
        $combiner = new WeatherServiceCombiner([
            $this->weatherService,
            $this->openWeatherService
        ]);

        return $combiner->averageTemperature($city, $countryCode);
    }
}
