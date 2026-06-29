<?php

namespace Tests\Feature;

use App\Enums\OrderStatus;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvoiceAccessTest extends TestCase
{
    use RefreshDatabase;

    private function makeInvoice(User $user): Invoice
    {
        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => '#5678',
            'address' => '1 rue du Test',
            'city' => 'Paris',
            'zip_code' => '75001',
            'order_date' => now()->toDateString(),
            'timeslot' => '09:00 - 12:00',
            'status' => OrderStatus::Delivered,
            'subtotal' => 20,
            'expedition' => 10,
            'tax' => 5,
        ]);

        return Invoice::create([
            'user_id' => $user->id,
            'order_id' => $order->id,
            'reference' => 'INV-TEST1234',
            'invoice_date' => now()->toDateString(),
            'total' => 35,
            'pdf_path' => 'invoices/inexistant.pdf',
        ]);
    }

    public function test_a_user_cannot_download_another_users_invoice(): void
    {
        /** @var User $owner */
        $owner = User::factory()->create();
        /** @var User $intruder */
        $intruder = User::factory()->create();
        $invoice = $this->makeInvoice($owner);

        $this->actingAs($intruder)
            ->get(route('invoices.download', $invoice->id))
            ->assertNotFound();
    }
}
