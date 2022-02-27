<?php

namespace App\Modules\Weather\WeatherServices;

interface WeatherService
{

    /**
     * @param string $city
     * @param string $countryCode
     * @return float temperature in celsius
     */
    public function getTemperature(string $city, string $countryCode): float;

    public function name(): string;

}
