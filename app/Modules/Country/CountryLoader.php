<?php

namespace App\Modules\Country;

use App\Helpers\File;
use App\Helpers\Json;

class CountryLoader
{

    public function list(): array
    {
        return collect($this->countriesData())
            ->map(fn($country) => [
                'name' => $country['name'],
                'code' => $country['alpha-2'],
            ])->all();
    }

    private function countriesData(): array
    {
        return Json::decode($this->loadCountriesFile());
    }

    private function loadCountriesFile(): string
    {
        return File::getContents(resource_path('data/country/countries.json'));
    }
}
