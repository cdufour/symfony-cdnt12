<?php

namespace App\Service;

class CalculatorService
{
    public const PI = 3.14;

    public function square(int $x)
    {
        return $x * $x;
    }
}