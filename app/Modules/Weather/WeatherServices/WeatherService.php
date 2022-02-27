<?php

namespace App\Modules\Weather\WeatherServices;

use App\Api\Weather\WeatherClient;

class WeatherService implements WeatherServiceInterface
{
    public function __construct(
        private WeatherClient $weatherClient
    ) {
    }

    public function getTemperature(string $city, string $countryCode): float
    {
        $response = $this->weatherClient->findWeather($city);

        return $response['current']['temp_c'];
    }
}
