<?php

namespace App\Rules;

use App\Modules\Country\CountryLoader;
use Illuminate\Contracts\Validation\Rule;

class ValidCountry implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $countryLoader = new CountryLoader();

        $codes = array_column($countryLoader->list(), 'code');

        return in_array($value, $codes);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The country has invalid code';
    }
}
