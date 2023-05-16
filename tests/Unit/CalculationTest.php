<?php

namespace Tests\Unit;

use App\Services\OrderService;
use PHPUnit\Framework\TestCase;

class CalculationTest extends TestCase
{
    public function test_calculation(): void
    {
        $rate = 0.91;
        $amount_EUR = 5500;
        $discount_pct = 2;
        $surcharge_pct = 5;

        $service = new OrderService();
        $calc = $service->getCalculationResult($amount_EUR, $rate, $surcharge_pct, $discount_pct);

        $this->assertEquals(275, $calc['surcharge']);
        $this->assertEquals(6346.15, $calc['surcharged_USD']);
        $this->assertEquals(120.87, $calc['discount_USD']);
        $this->assertEquals(6225.28, $calc['total_USD']);
    }
}
