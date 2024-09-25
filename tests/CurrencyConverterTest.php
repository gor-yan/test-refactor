<?php

use PHPUnit\Framework\TestCase;
use App\Classes\CurrencyConverter;

class CurrencyConverterTest extends TestCase
{
    public function testConvertToEuro()
    {
        $converter = new CurrencyConverter();
        $this->assertEquals(100, $converter->convert(100, 'EUR'));
    }

    public function testConvertFromNonEuro()
    {
        $converter = new CurrencyConverter();
        // Assuming the exchange rate for USD is 0.85 for the sake of the test
        $this->assertEquals(117.65, round($converter->convert(100, 'USD'), 2));
    }
}