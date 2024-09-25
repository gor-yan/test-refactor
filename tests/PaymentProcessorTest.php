<?php

use PHPUnit\Framework\TestCase;
use App\Classes\PaymentProcessor;
use App\Interfaces\CurrencyConverterInterface;
use App\Interfaces\CountryCheckerInterface;

class CountryCheckerTest extends TestCase
{
    public function testProcessFile()
    {
        $currencyConverter = $this->createMock(CurrencyConverterInterface::class);
        $countryChecker = $this->createMock(CountryCheckerInterface::class);

        $currencyConverter->method('convert')->willReturn(100);
        $countryChecker->method('isEu')->willReturn(true);

        $processor = new PaymentProcessor($currencyConverter, $countryChecker);
        $processor->processFile('test_data.txt');
    }
}