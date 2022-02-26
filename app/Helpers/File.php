<?php

namespace App\Helpers;

class File
{

    public static function getContents(string $path): string
    {
        $contents = file_get_contents($path);

        if ($contents === false) {
            throw new \Exception(sprintf('File at path %s not found', $path));
        }

        return $contents;
    }

}
