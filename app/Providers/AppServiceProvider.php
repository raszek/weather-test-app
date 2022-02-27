<?php

namespace App\Providers;

use App\Api\OpenWeather\OpenWeatherClient;
use App\Api\Weather\WeatherClient;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(OpenWeatherClient::class, function () {
            return new OpenWeatherClient(
                token: config('services.open-weather')['token'],
            );
        });

        $this->app->bind(WeatherClient::class, function () {
            return new WeatherClient(
                token: config('services.weather')['token'],
            );
        });
    }
}
