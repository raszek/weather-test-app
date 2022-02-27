<?php

namespace App\Modules\Weather\WeatherServices;

use App\Api\OpenWeather\OpenWeatherClient;

class OpenWeatherService implements WeatherServiceInterface
{
    public function __construct(
        private OpenWeatherClient $client
    ) {
    }

    public function getTemperature(string $city, string $countryCode): float
    {
         return $this->getTemperateInCelsius($this->client->findWeather($city, $countryCode));
    }

    private function getTemperateInCelsius(array $response): float
    {
        return $this->convertKelvinToCelsius($response['main']['temp']);
    }

    private function convertKelvinToCelsius(float $kelvins): float
    {
        return $kelvins - 273;
    }
}
