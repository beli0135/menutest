<?php

namespace App\Helpers;

class AppHelper
{
    public static function instance(): AppHelper
    {
        return new AppHelper();
    }

    public static function truncToTwoDecimals(float $value): float
    {
        return floor($value * 100) / 100;
    }
}