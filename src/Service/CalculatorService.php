<?php

namespace App\Service;
use Symfony\Component\HttpFoundation\Response;

class CalculatorService
{
    public const PI = 3.14;
    // Appel => CalculatorService::PI

    // Autre syntaxe possible:
    // public static $PI = 3.14;
    // Appel => CalculatorService::$PI

    public function square(int $x)
    {
        return $x * $x;
    }
}