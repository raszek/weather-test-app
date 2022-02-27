<?php

namespace App\Api\OpenWeather;

use App\Helpers\Json;
use GuzzleHttp\Client;

class OpenWeatherClient
{

    private Client $guzzle;

    public function __construct(
        private string $token
    ) {
        $this->guzzle = new Client([
            'base_uri' => 'https://api.openweathermap.org/data/2.5/',
        ]);
    }

    public function findWeather(string $city, string $countryCode)
    {
        $response = $this->get('weather', [
            'q' => $city.', '.$countryCode
        ]);

        return Json::decode($response->getBody()->getContents());
    }

    private function get(string $url, array $params = [])
    {
        return $this->guzzle->get($url, [
            'query' => $this->createQuery($params)
        ]);
    }

    private function createQuery(array $params)
    {
        return array_merge([
            'appid' => $this->token,
        ], $params);
    }
}
