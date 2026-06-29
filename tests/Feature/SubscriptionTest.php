<?php

namespace Tests\Feature;

use App\Models\Subscription;
use App\Models\User;
use App\Services\SubscriptionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubscriptionTest extends TestCase
{
    use RefreshDatabase;

    private function premiumPlan(): Subscription
    {
        return Subscription::create([
            'name' => 'Premium',
            'price' => 1990,
            'status' => 'active',
            'stripe_price_id' => 'price_test',
            'benefits' => ['−10 % sur chaque commande'],
        ]);
    }

    public function test_free_user_sees_the_premium_offer(): void
    {
        $this->premiumPlan();
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('account.subscription'))
            ->assertOk()
            ->assertSee('Offre gratuite')
            ->assertSee('Passer au Premium');
    }

    public function test_activation_makes_the_user_premium(): void
    {
        $plan = $this->premiumPlan();
        $user = User::factory()->create();

        app(SubscriptionService::class)->activate($user->id, 'cus_test', 'sub_test');

        $user->refresh();
        $this->assertTrue($user->hasActiveSubscription());
        $this->assertSame($plan->id, $user->subscription_id);
    }

    public function test_deactivation_reverts_the_user_to_free(): void
    {
        $this->premiumPlan();
        $user = User::factory()->create([
            'stripe_subscription_id' => 'sub_test',
            'subscription_status' => 'active',
        ]);

        app(SubscriptionService::class)->deactivate('sub_test');

        $user->refresh();
        $this->assertFalse($user->hasActiveSubscription());
        $this->assertNull($user->subscription_id);
    }

    public function test_subscription_page_requires_authentication(): void
    {
        $this->get(route('account.subscription'))->assertRedirect(route('login'));
    }
}
