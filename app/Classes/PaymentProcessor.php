<?php

namespace App\Classes;

use App\Interfaces\CurrencyConverterInterface;
use App\Interfaces\CountryCheckerInterface;
use RuntimeException;

class PaymentProcessor
{
    private $currencyConverter;
    private $countryChecker;

    public function __construct(CurrencyConverterInterface $currencyConverter, CountryCheckerInterface $countryChecker)
    {
        $this->currencyConverter = $currencyConverter;
        $this->countryChecker = $countryChecker;
    }

    public function processFile(string $filePath): void
    {
        foreach (explode("\n", file_get_contents($filePath)) as $row) {
            if (empty($row)) continue;

            $data = $this->parseRow($row);
            $binData = $this->getBinData($data['bin']);
            $isEu = $this->countryChecker->isEu($binData->country->alpha2);
            $amountFixed = $this->currencyConverter->convert($data['amount'], $data['currency']);

            echo $amountFixed * ($isEu ? 0.01 : 0.02);
            print "\n";
        }
    }

    private function parseRow(string $row): array
    {
        $values = explode(",", $row);
        return [
            'bin' => trim(explode(':', $values[0])[1], '"'),
            'amount' => (float)trim(explode(':', $values[1])[1], '"'),
            'currency' => trim(explode(':', $values[2])[1], '"}')
        ];
    }

    private function getBinData(string $bin): \stdClass
    {
        $binResults = file_get_contents('https://lookup.binlist.net/' . $bin);
        if (!$binResults) {
            throw new RuntimeException('Error fetching BIN data.');
        }
        return json_decode($binResults);
    }
}