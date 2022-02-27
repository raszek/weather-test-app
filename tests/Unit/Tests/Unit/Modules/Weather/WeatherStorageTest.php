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

}
