<?php

namespace Tests\Unit;

use App\Models\Order;
use PHPUnit\Framework\TestCase;

class OrderTotalTest extends TestCase
{
    public function test_total_sums_subtotal_delivery_and_tax(): void
    {
        $order = new Order([
            'subtotal' => 45.50,
            'expedition' => 10,
            'tax' => 5,
        ]);

        $this->assertSame(60.5, $order->total);
    }

    public function test_total_is_zero_for_empty_order(): void
    {
        $order = new Order(['subtotal' => 0, 'expedition' => 0, 'tax' => 0]);

        $this->assertSame(0.0, $order->total);
    }

    public function test_total_subtracts_the_discount(): void
    {
        $order = new Order([
            'subtotal' => 100,
            'discount' => 10,
            'expedition' => 10,
            'tax' => 5,
        ]);

        $this->assertSame(105.0, $order->total);
    }
}
