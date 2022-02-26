<?php

namespace App\Helpers;

class Json
{

    public static function decode(string $json): array
    {
        return json_decode(
            $json,
            associative: true,
            flags: JSON_THROW_ON_ERROR
        );
    }

}
