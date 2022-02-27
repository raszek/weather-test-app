<?php

namespace App\Modules\Weather;

use App\Models\WeatherRecord;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Date;

class WeatherStorage
{

    public function saveWeather(WeatherRecord $weatherRecord)
    {
        $weatherRecord->date = Date::now()->toDateString();
        $weatherRecord->save();
        $this->cacheWeather($weatherRecord);
    }

    public function getWeatherTemperature(string $city, $countryCode): ?float
    {
        $cacheKey = $this->weatherRecordKey(new WeatherRecord([
            'date' => Date::now()->toDateString(),
            'city' => $city,
            'country_code' => $countryCode
        ]));

        $value = Cache::get($cacheKey);

        if ($value) {
            return $value;
        }

        $record = WeatherRecord::where([
            'date' => Date::now()->toDateString(),
            'city' => $city,
            'country_code' => $countryCode
        ])->first();

        if (!$record) {
            return null;
        }

        return $record->temperature;
    }

    private function cacheWeather(WeatherRecord $weatherRecord)
    {
        Cache::add($this->weatherRecordKey($weatherRecord), $weatherRecord->temperature);
    }

    private function weatherRecordKey(WeatherRecord $weatherRecord): string
    {
        return $weatherRecord->date.'-'.$weatherRecord->country_code.'-'.$weatherRecord->city;
    }
}
