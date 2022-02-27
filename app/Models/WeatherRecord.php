<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $date
 * @property string $city
 * @property string $country_code
 * @property float $temperature
 */
class WeatherRecord extends Model
{
    use HasFactory;

    protected $table = 'weather_record';

    protected $fillable = ['city', 'country_code', 'temperature'];
}
