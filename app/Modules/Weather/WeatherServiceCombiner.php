<?php

namespace App\Modules\Weather;

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

    public function averageTemperature(string $city, string $countryCode): float
    {
        if (count($this->weatherServices) === 0) {
            return 0;
        }

        $temperature = 0;
        foreach ($this->weatherServices as $weatherService) {
            $temperature += $weatherService->getTemperature($city, $countryCode);
        }

        return $temperature / count($this->weatherServices);
    }

    private function addWeatherService(WeatherServiceInterface $weatherService)
    {
        $this->weatherServices []= $weatherService;
    }
}
