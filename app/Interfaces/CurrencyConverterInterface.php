<?php

namespace App\Interfaces;

interface CurrencyConverterInterface
{
    public function convert(float $amount, string $currency): float;
}