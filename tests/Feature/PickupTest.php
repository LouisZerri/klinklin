<?php

namespace Tests\Feature;

use App\Enums\OrderStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PickupTest extends TestCase
{
    use RefreshDatabase;

    public function test_starting_a_pickup_creates_a_pending_order(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('post_address'), [
            'address' => '12 rue de la République',
            'city' => 'Paris',
            'zip_code' => '75001',
            'order_date' => now()->addDay()->toDateString(),
            'timeslot' => '09:00 - 12:00',
        ]);

        $response->assertRedirect(route('articles'));
        $response->assertSessionHas('order_id');

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'status' => OrderStatus::Pending->value,
            'city' => 'Paris',
        ]);
    }

    public function test_pickup_requires_authentication(): void
    {
        $this->get(route('collecte'))->assertRedirect(route('login'));
    }
}
