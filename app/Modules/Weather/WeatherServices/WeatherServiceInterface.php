<?php

namespace App\Modules\Weather\WeatherServices;

interface WeatherServiceInterface
{

    /**
     * @param string $city
     * @param string $countryCode
     * @return float temperature in celsius
     * @throws CityNotFoundException
     */
    public function getTemperature(string $city, string $countryCode): float;
}
