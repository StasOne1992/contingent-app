<?php

namespace App\Extension\Npub\Gos\Snils;

use Npub\Gos\Snils;

class SnilsExtension extends Snils
{
    public const ID_MIN = 1001999;
    public const ID_MAX = 999999999;


    static function getRandomSnils():Snils
    {
        return new Snils(rand(self::ID_MIN, self::ID_MAX));
    }
}