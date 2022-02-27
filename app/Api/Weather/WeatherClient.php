<?php

namespace App\Api\Weather;

use App\Helpers\Json;
use GuzzleHttp\Client;

class WeatherClient
{

    private Client $guzzle;

    public function __construct(
        private string $token
    ) {
        $this->guzzle = new Client([
            'base_uri' => 'https://api.weatherapi.com/v1/',
        ]);
    }

    public function findWeather(string $city)
    {
        $response = $this->get('current.json', [
            'q' => $city
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
            'key' => $this->token,
            'aqi' => 'no'
        ], $params);
    }
}
