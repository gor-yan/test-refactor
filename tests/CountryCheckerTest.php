<?php

use PHPUnit\Framework\TestCase;
use App\Classes\CountryChecker;

class CountryCheckerTest extends TestCase
{
    public function testIsEu()
    {
        $checker = new CountryChecker();
        $this->assertTrue($checker->isEu('DE'));
        $this->assertFalse($checker->isEu('US'));
    }
}