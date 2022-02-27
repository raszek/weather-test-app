<?php

namespace App\Modules\Weather\WeatherServices;

use App\Api\Weather\WeatherClient;
use App\Modules\Country\CountryLoader;
use GuzzleHttp\Exception\ClientException;

class WeatherService implements WeatherServiceInterface
{
    public function __construct(
        private WeatherClient $weatherClient,
        private CountryLoader $countryLoader
    ) {
    }

    public function getTemperature(string $city, string $countryCode): float
    {
        try {
            $response = $this->weatherClient->findWeather($city);
        } catch (ClientException) {
            throw new CityNotFoundException();
        }

        $this->guardAgainstInvalidCountry($response, $countryCode);

        return $response['current']['temp_c'];
    }

    private function guardAgainstInvalidCountry(array $response, string $code)
    {
        $country = $this->countryLoader->findCountryByCode($code);

        if ($response['location']['country'] !== $country['name']) {
            throw new CityNotFoundException();
        }
    }
}
