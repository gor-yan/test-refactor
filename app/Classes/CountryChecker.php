<?php

namespace App\Classes;

use App\Interfaces\CountryCheckerInterface;

class CountryChecker implements CountryCheckerInterface
{
    private $euCountries = [
        'AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES',
        'FI', 'FR', 'GR', 'HR', 'HU', 'IE', 'IT', 'LT', 'LU',
        'LV', 'MT', 'NL', 'PO', 'PT', 'RO', 'SE', 'SI', 'SK'
    ];

    public function isEu(string $countryCode): bool
    {
        return in_array($countryCode, $this->euCountries);
    }
}