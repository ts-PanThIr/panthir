<?php

namespace App\Shared\Helper;

class Slugify
{
    public static function slugify(string $string): string
    {
        return strtolower($string);
    }
}
