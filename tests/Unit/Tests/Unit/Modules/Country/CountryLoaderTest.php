<?php

namespace Tests\Unit\Modules\Country;

use App\Modules\Country\CountryLoader;
use Tests\TestCase;

class CountryLoaderTest extends TestCase
{

    /** @test */
    public function can_load_all_countries_as_array()
    {
        $countryLoader = new CountryLoader();

        $countryList = $countryLoader->list();

        $this->assertIsArray($countryList);
    }

    /** @test */
    public function country_has_code()
    {
        $countryLoader = new CountryLoader();

        $countryList = $countryLoader->list();

        $this->assertArrayHasKey('code', $countryList[0]);
    }

    /** @test */
    public function country_has_name()
    {
        $countryLoader = new CountryLoader();

        $countryList = $countryLoader->list();

        $this->assertArrayHasKey('name', $countryList[0]);
    }

}
