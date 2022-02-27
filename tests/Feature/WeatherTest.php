<?php

namespace Tests\Feature;

use App\Modules\Weather\WeatherModule;
use App\Modules\Weather\WeatherServices\OpenWeatherService;
use Mockery\MockInterface;
use Tests\TestCase;

class WeatherTest extends TestCase
{
    /** @test */
    public function it_loads_weather_form()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /** @test */
    public function on_form_submit_city_is_required()
    {
        $response = $this
            ->followingRedirects()
            ->post('/', [
            'country' => 'PL',
            'city' => '',
        ]);

        $response->assertStatus(200);
        $response->assertSeeText('The city field is required.');
    }

    /** @test */
    public function country_must_have_valid_code()
    {
        $response = $this
            ->followingRedirects()
            ->post('/', [
                'country' => 'invalid-code',
                'city' => 'Olsztyn',
            ]);

        $response->assertStatus(200);
        $response->assertSeeText('The country has invalid code');
    }

    /** @test */
    public function user_can_select_country_and_input_city_to_get_the_temperature()
    {
        $this->partialMock(WeatherModule::class, function (MockInterface $mock) {
            $mock->shouldReceive('getAverageTemperature')->andReturn(8);
        });

        $response = $this
            ->followingRedirects()
            ->post('/', [
            'country' => 'PL',
            'city' => 'Olsztyn',
        ]);

        $response->assertStatus(200);
        $response->assertSeeText('Temperature in Poland, Olsztyn is 8 degrees celsius');
    }
}
