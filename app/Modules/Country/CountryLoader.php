<?php

namespace App\Modules\Country;

use App\Helpers\File;
use App\Helpers\Json;

class CountryLoader
{

    private ?array $countryList = null;

    public function list(): array
    {
        if (!$this->countryList) {
            $this->countryList = collect($this->countriesData())
            ->map(fn($country) => [
                'name' => $country['name'],
                'code' => $country['alpha-2'],
            ])->all();
        }

        return $this->countryList;
    }

    public function findCountryByCode(string $code)
    {
        return collect($this->list())->first(fn($ctr) => $ctr['code'] === $code);
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
