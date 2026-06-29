<?php

namespace App\Services;

use App\Models\Subscription;
use App\Models\User;

class SubscriptionService
{
    /**
     * Active l'abonnement Premium d'un utilisateur après un paiement réussi.
     */
    public function activate(int $userId, string $customerId, string $stripeSubscriptionId): void
    {
        $user = User::find($userId);
        $premium = Subscription::where('name', 'Premium')->first();

        if (! $user || ! $premium) {
            return;
        }

        $user->update([
            'subscription_id' => $premium->id,
            'stripe_customer_id' => $customerId,
            'stripe_subscription_id' => $stripeSubscriptionId,
            'subscription_status' => 'active',
            'subscription_ends_at' => null,
        ]);
    }

    /**
     * Repasse un utilisateur en offre gratuite (résiliation).
     */
    public function deactivate(string $stripeSubscriptionId): void
    {
        $user = User::where('stripe_subscription_id', $stripeSubscriptionId)->first();

        if (! $user) {
            return;
        }

        $user->update([
            'subscription_id' => null,
            'stripe_subscription_id' => null,
            'subscription_status' => 'canceled',
            'subscription_ends_at' => now(),
        ]);
    }
}
