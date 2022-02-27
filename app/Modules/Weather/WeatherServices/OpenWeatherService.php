<?php

namespace App\Modules\Weather\WeatherServices;

use App\Api\OpenWeather\OpenWeatherClient;
use GuzzleHttp\Exception\ClientException;

class OpenWeatherService implements WeatherServiceInterface
{
    public function __construct(
        private OpenWeatherClient $client
    ) {
    }

    public function getTemperature(string $city, string $countryCode): float
    {
        try {
            return $this->getTemperateInCelsius($this->client->findWeather($city, $countryCode));
        } catch (ClientException) {
            throw new CityNotFoundException('City not found');
        }
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
