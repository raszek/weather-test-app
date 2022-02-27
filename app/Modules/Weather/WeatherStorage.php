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

    private function cacheWeather(WeatherRecord $weatherRecord)
    {
        Cache::add($this->weatherRecordKey($weatherRecord), $weatherRecord->temperature);
    }

    private function weatherRecordKey(WeatherRecord $weatherRecord): string
    {
        return $weatherRecord->date.'-'.$weatherRecord->country_code.'-'.$weatherRecord->city;
    }
}
