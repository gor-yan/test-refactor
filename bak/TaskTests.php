<?php

use PHPUnit\Framework\TestCase;

class TaskTests extends TestCase {

    public function testParseRow() {
        $this->assertEquals(['123456', '100', 'USD'], parseRow('BIN: "123456", Amount: "100", Currency: "USD"'));
        $this->assertNull(parseRow('Incomplete data'));
    }

    public function testIsEu() {
        $this->assertEquals('yes', isEu('DE'));
        $this->assertEquals('no', isEu('US'));
    }

    public function testCalculateAmountFixed() {
        $this->assertEquals(100, calculateAmountFixed(100, 0, 'EUR'));
        $this->assertEquals(50, calculateAmountFixed(100, 2, 'USD'));
    }

    public function testFetchExchangeRate() {
        $this->assertGreaterThan(0, fetchExchangeRate('USD'));
    }

    public function testFetchBinData() {
        $this->assertNotNull(fetchBinData('123456'));
    }
}