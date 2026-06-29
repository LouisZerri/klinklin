<?php

namespace Tests\Feature;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderAccessTest extends TestCase
{
    use RefreshDatabase;

    private function makeOrder(User $user, OrderStatus $status = OrderStatus::Scheduled): Order
    {
        return Order::create([
            'user_id' => $user->id,
            'order_number' => '#1234',
            'address' => '1 rue du Test',
            'city' => 'Paris',
            'zip_code' => '75001',
            'order_date' => now()->toDateString(),
            'timeslot' => '09:00 - 12:00',
            'status' => $status,
            'subtotal' => 20,
            'expedition' => 10,
            'tax' => 5,
        ]);
    }

    public function test_guest_cannot_access_orders(): void
    {
        $this->get(route('orders.index'))->assertRedirect(route('login'));
    }

    public function test_a_user_can_view_their_own_order(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $order = $this->makeOrder($user);

        $this->actingAs($user)->get(route('orders.show', $order->id))->assertOk();
    }

    public function test_a_user_cannot_view_another_users_order(): void
    {
        /** @var User $owner */
        $owner = User::factory()->create();
        /** @var User $intruder */
        $intruder = User::factory()->create();
        $order = $this->makeOrder($owner);

        $this->actingAs($intruder)->get(route('orders.show', $order->id))->assertNotFound();
    }

    public function test_a_user_cannot_cancel_another_users_order(): void
    {
        /** @var User $owner */
        $owner = User::factory()->create();
        /** @var User $intruder */
        $intruder = User::factory()->create();
        $order = $this->makeOrder($owner);

        $this->actingAs($intruder)->post(route('order.cancel', $order->id))->assertNotFound();
    }
}
