<?php

namespace App\Interfaces;

interface CountryCheckerInterface
{
    public function isEu(string $countryCode): bool;
}