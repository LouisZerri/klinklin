<?php

namespace Tests\Feature;

use App\Enums\OrderStatus;
use App\Models\Article;
use App\Models\Order;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PremiumDiscountTest extends TestCase
{
    use RefreshDatabase;

    private function makeArticle(): Article
    {
        return Article::create([
            'name' => 'Chemise',
            'type' => 'Vêtements',
            'usage' => ['Lavage'],
            'unit_price' => 10,
            'weight_ranges' => ['léger' => [0.2, 0.3]],
        ]);
    }

    private function makeOrder(User $user): Order
    {
        return Order::create([
            'user_id' => $user->id,
            'order_number' => '#1000',
            'address' => '1 rue du Test',
            'city' => 'Paris',
            'zip_code' => '75001',
            'order_date' => now()->toDateString(),
            'timeslot' => '09:00 - 12:00',
            'status' => OrderStatus::Pending,
            'subtotal' => 0,
            'expedition' => 10,
            'tax' => 5,
        ]);
    }

    private function articlesPayload(Article $article): array
    {
        return [
            'articles_data' => json_encode([[
                'article_id' => $article->id,
                'name' => $article->name,
                'quantity' => 3,
                'avg_weight' => 0.75,
                'unit_price' => 10,
            ]]),
        ];
    }

    public function test_premium_user_gets_a_ten_percent_discount(): void
    {
        $plan = Subscription::create(['name' => 'Premium', 'price' => 1990, 'status' => 'active']);
        /** @var User $user */
        $user = User::factory()->create([
            'subscription_id' => $plan->id,
            'stripe_subscription_id' => 'sub_test',
            'subscription_status' => 'active',
        ]);
        $article = $this->makeArticle();
        $order = $this->makeOrder($user);

        $this->actingAs($user)
            ->withSession(['order_id' => $order->id])
            ->post(route('post_articles'), $this->articlesPayload($article));

        $order->refresh();
        // 3 × 10 € = 30 € de sous-total → 3 € de remise
        $this->assertEquals(30, $order->subtotal);
        $this->assertEquals(3, $order->discount);
        $this->assertEquals(42, $order->total); // 30 − 3 + 10 + 5
    }

    public function test_premium_user_gets_free_delivery(): void
    {
        $plan = Subscription::create(['name' => 'Premium', 'price' => 999, 'status' => 'active']);
        /** @var User $user */
        $user = User::factory()->create([
            'subscription_id' => $plan->id,
            'stripe_subscription_id' => 'sub_test',
            'subscription_status' => 'active',
        ]);

        $this->actingAs($user)->post(route('post_address'), [
            'address' => '12 rue de la République',
            'city' => 'Paris',
            'zip_code' => '75001',
            'order_date' => now()->addDay()->toDateString(),
            'timeslot' => '09:00 - 12:00',
        ]);

        $this->assertEquals(0, Order::where('user_id', $user->id)->latest('id')->first()->expedition);
    }

    public function test_free_user_pays_delivery(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('post_address'), [
            'address' => '12 rue de la République',
            'city' => 'Paris',
            'zip_code' => '75001',
            'order_date' => now()->addDay()->toDateString(),
            'timeslot' => '09:00 - 12:00',
        ]);

        $this->assertEquals(10, Order::where('user_id', $user->id)->latest('id')->first()->expedition);
    }

    public function test_free_user_gets_no_discount(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $article = $this->makeArticle();
        $order = $this->makeOrder($user);

        $this->actingAs($user)
            ->withSession(['order_id' => $order->id])
            ->post(route('post_articles'), $this->articlesPayload($article));

        $order->refresh();
        $this->assertEquals(0, $order->discount);
        $this->assertEquals(45, $order->total); // 30 + 10 + 5
    }
}
