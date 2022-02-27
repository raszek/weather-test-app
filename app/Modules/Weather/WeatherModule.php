<?php

namespace App\Modules\Weather;

use App\Models\WeatherRecord;
use App\Modules\Weather\WeatherServices\OpenWeatherService;
use App\Modules\Weather\WeatherServices\WeatherService;

class WeatherModule
{

    public function __construct(
        private WeatherService $weatherService,
        private OpenWeatherService $openWeatherService,
        private WeatherStorage $storage
    ) {
    }

    /**
     * @param string $city
     * @param string $countryCode
     * @return float
     * @throws TemperatureNotFoundException
     */
    public function getAverageTemperature(string $city, string $countryCode): float
    {
        $temperature = $this->storage->getWeatherTemperature($city, $countryCode);

        if ($temperature) {
            return $temperature;
        }

        $combiner = new WeatherServiceCombiner([
            $this->weatherService,
            $this->openWeatherService
        ]);

        $temperature = $combiner->averageTemperature($city, $countryCode);

        $this->storage->saveWeather(new WeatherRecord([
            'city' => $city,
            'country_code' => $countryCode,
            'temperature' => $temperature
        ]));

        return $temperature;
    }
}
