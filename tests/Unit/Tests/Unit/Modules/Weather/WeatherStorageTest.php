<?php

namespace Tests\Unit\Modules\Weather;

use App\Models\WeatherRecord;
use App\Modules\Weather\WeatherStorage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class WeatherStorageTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function it_can_write_weather_record_to_database()
    {
        $this->travelTo('2010-10-10');

        $record = new WeatherRecord([
            'city' => 'Warsaw',
            'country_code' => 'PL',
            'temperature' => 5.5
        ]);

        $storage = new WeatherStorage();

        $storage->saveWeather($record);

        $this->assertDatabaseHas('weather_record', [
            'date' => '2010-10-10',
            'city' => 'Warsaw',
            'country_code' => 'PL',
            'temperature' => 5.5
        ]);

        $cacheValue = Cache::get('2010-10-10-PL-Warsaw');

        $this->assertEquals(5.5, $cacheValue);
    }

    /** @test */
    public function it_searches_for_temperature_in_cache_first()
    {
        $this->travelTo('2010-10-10');

        Cache::add('2010-10-10-PL-Warsaw', 11);

        $storage = new WeatherStorage();

        $temperature = $storage->getWeatherTemperature('Warsaw', 'PL');

        $this->assertEquals(11, $temperature);
    }

    /** @test */
    public function it_can_find_weather_record_in_database_at_current_day()
    {
        $this->travelTo('2010-10-10');

        WeatherRecord::factory()->create([
            'date' => '2010-10-10',
            'city' => 'Warsaw',
            'country_code' => 'PL',
            'temperature' => 5
        ]);

        $storage = new WeatherStorage();

        $temperature = $storage->getWeatherTemperature('Warsaw', 'PL');

        $this->assertEquals(5, $temperature);
    }
}
