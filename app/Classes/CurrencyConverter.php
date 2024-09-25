<?php

namespace App\Classes;

use App\Interfaces\CurrencyConverterInterface;

class CurrencyConverter implements CurrencyConverterInterface
{
    private $exchangeRates;

    public function __construct()
    {
        $this->exchangeRates = json_decode(file_get_contents('https://api.exchangeratesapi.io/latest'), true)['rates'];
    }

    public function convert(float $amount, string $currency): float
    {
        if ($currency == 'EUR' || !isset($this->exchangeRates[$currency])) {
            return $amount;
        }
        return $amount / $this->exchangeRates[$currency];
    }
}