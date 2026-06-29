<?php

namespace Tests\Unit;

use App\Enums\OrderStatus;
use PHPUnit\Framework\TestCase;

class OrderStatusTest extends TestCase
{
    public function test_tracking_steps_are_ordered(): void
    {
        $steps = OrderStatus::trackingSteps();

        $this->assertCount(5, $steps);
        $this->assertSame(OrderStatus::Scheduled, $steps[0]);
        $this->assertSame(OrderStatus::Delivered, $steps[4]);
    }

    public function test_tracking_index_reflects_progress(): void
    {
        $this->assertSame(0, OrderStatus::Scheduled->trackingIndex());
        $this->assertSame(4, OrderStatus::Delivered->trackingIndex());
        // Une commande terminée est considérée comme livrée (dernière étape).
        $this->assertSame(4, OrderStatus::Completed->trackingIndex());
        // Hors suivi : pas d'étape.
        $this->assertNull(OrderStatus::Pending->trackingIndex());
        $this->assertNull(OrderStatus::Cancelled->trackingIndex());
    }

    public function test_cancellation_helpers(): void
    {
        $this->assertTrue(OrderStatus::Cancelled->isCancelled());
        $this->assertFalse(OrderStatus::Scheduled->isCancelled());

        // Seule une commande planifiée (payée) est annulable / remboursable.
        $this->assertTrue(OrderStatus::Scheduled->isCancellable());
        $this->assertFalse(OrderStatus::Pending->isCancellable());
        $this->assertFalse(OrderStatus::Delivered->isCancellable());
    }
}
