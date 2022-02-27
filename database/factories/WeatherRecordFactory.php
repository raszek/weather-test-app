<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WeatherRecord>
 */
class WeatherRecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'date' => $this->faker->date(),
            'city' => $this->faker->city(),
            'country_code' => $this->faker->countryCode(),
            'temperature' => $this->faker->randomFloat(0, 30)
        ];
    }
}
