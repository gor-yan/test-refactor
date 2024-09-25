<?php
require __DIR__ . '/vendor/autoload.php';

use App\Classes\CountryChecker;
use App\Classes\CurrencyConverter;
use App\Classes\PaymentProcessor;

$currencyConverter = new CurrencyConverter();
$countryChecker = new CountryChecker();
$paymentProcessor = new PaymentProcessor($currencyConverter, $countryChecker);
$paymentProcessor->processFile($argv[1]);