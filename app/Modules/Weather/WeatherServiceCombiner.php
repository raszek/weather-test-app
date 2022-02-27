<?php

namespace App\Modules\Weather;

use App\Modules\Weather\WeatherServices\CityNotFoundException;
use App\Modules\Weather\WeatherServices\WeatherServiceInterface;

class WeatherServiceCombiner
{

    /**
     * @param WeatherServiceInterface[] $weatherServices
     */
    private array $weatherServices = [];

    public function __construct(array $weatherServices)
    {
        foreach ($weatherServices as $weatherService) {
            $this->addWeatherService($weatherService);
        }
    }

    /**
     * @param string $city
     * @param string $countryCode
     * @return float
     * @throws TemperatureNotFoundException
     */
    public function averageTemperature(string $city, string $countryCode): float
    {
        $temperatures = [];
        foreach ($this->weatherServices as $weatherService) {
            try {
                $temperatures []= $weatherService->getTemperature($city, $countryCode);
            } catch (CityNotFoundException) {
                continue;
            }
        }

        if (count($temperatures) === 0) {
            throw new TemperatureNotFoundException();
        }

        return array_sum($temperatures) / count($temperatures);
    }

    private function addWeatherService(WeatherServiceInterface $weatherService)
    {
        $this->weatherServices []= $weatherService;
    }
}
