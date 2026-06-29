<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StripeWebhookTest extends TestCase
{
    use RefreshDatabase;

    public function test_webhook_rejects_an_invalid_signature(): void
    {
        // Pas de signature Stripe valide → la requête doit être refusée (400),
        // et non bloquée par le CSRF (sinon ce serait 419).
        $response = $this->postJson('/stripe/webhook', [
            'type' => 'payment_intent.succeeded',
        ]);

        $response->assertStatus(400);
    }
}
