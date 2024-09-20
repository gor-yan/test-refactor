<?php

/**
 * @param string $filePath
 */
function processFile(string $filePath): void {
    $rows = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($rows as $row) {
        $values = parseRow($row);
        if ($values === false) {
            continue; // Skip invalid rows
        }

        $binData = fetchBinData($values[0]);
        if ($binData === null) {
            continue; // Skip if bin data could not be fetched
        }

        $exchangeRate = fetchExchangeRate($values[2]);
        $amountFixed = calculateAmount($values[1], $exchangeRate, $values[2]);
        $isEu = isEu($binData->country->alpha2);

        echo calculateFinalAmount($amountFixed, $isEu);
        print "\n";
    }
}

/**
 * @param string $row
 * @return array|null
 */
function parseRow(string $row): ?array {
    $parts = explode(",", $row);
    if (count($parts) < 3) return null;

    return [
        trim(explode(':', $parts[0])[1], '"'),
        trim(explode(':', $parts[1])[1], '"'),
        trim(explode(':', $parts[2])[1], '"}')
    ];
}

/**
 * @param string $bin
 * @return object|null
 */
function fetchBinData(string $bin): ?object {
    $binResults = file_get_contents('https://lookup.binlist.net/' . $bin);
    return $binResults ? json_decode($binResults) : null;
}

/**
 * @param string $currency
 * @return float
 */
function fetchExchangeRate(string $currency): float {
    $rateData = @json_decode(file_get_contents('https://api.exchangeratesapi.io/latest'), true);
    return $rateData['rates'][$currency] ?? 0.0;
}

/**
 * @param float $amount
 * @param float $exchangeRate
 * @param string $currency
 * @return float
 */
function calculateAmount(float $amount, float $exchangeRate, string $currency): float {
    if ($currency === 'EUR' || $exchangeRate === 0) {
        return $amount;
    }
    return $amount / $exchangeRate;
}

/**
 * @param float $amountFixed
 * @param string $isEu
 * @return float
 */
function calculateFinalAmount(float $amountFixed, string $isEu): float {
    return $amountFixed * ($isEu ? 0.01 : 0.02);
}

/**
 * @param string $countryCode
 * @return string
 */
function isEu(string $countryCode): string {
    $euCountries = [
        'AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES',
        'FI', 'FR', 'GR', 'HR', 'HU', 'IE', 'IT', 'LT', 'LU',
        'LV', 'MT', 'NL', 'PO', 'PT', 'RO', 'SE', 'SI', 'SK'
    ];
    return in_array($countryCode, $euCountries);
}

// Call the function
processFile($argv[1]);