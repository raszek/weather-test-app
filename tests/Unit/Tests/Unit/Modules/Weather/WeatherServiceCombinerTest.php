<?php

namespace Tests\Unit\Modules\Weather;

use App\Modules\Weather\WeatherServiceCombiner;
use App\Modules\Weather\WeatherServices\WeatherServiceInterface;
use Mockery\MockInterface;
use Tests\TestCase;

class WeatherServiceCombinerTest extends TestCase
{

    /** @test */
    public function it_should_return_average_for_each_given_temperature_from_service()
    {
        $service1 = $this->partialMock(WeatherServiceInterface::class, function (MockInterface $mock) {
            $mock->shouldReceive('getTemperature')->andReturn(7);
        });

        $service2 = $this->partialMock(WeatherServiceInterface::class, function (MockInterface $mock) {
            $mock->shouldReceive('getTemperature')->andReturn(8);
        });

        $combiner = new WeatherServiceCombiner([
            $service1,
            $service2
        ]);

        $this->assertEquals(7.5, $combiner->averageTemperature('Some city', 'GB'));
    }

}
