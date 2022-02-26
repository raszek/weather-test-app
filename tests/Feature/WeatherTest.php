<?php

namespace Tests\Feature;

use Tests\TestCase;

class WeatherTest extends TestCase
{
    /** @test */
    public function it_loads_weather_form()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
