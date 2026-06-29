<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    /**
     * Page "Mon abonnement" : offre gratuite vs Premium.
     */
    public function index()
    {
        return view('account.subscription', [
            'user' => Auth::user(),
            'premium' => Subscription::where('name', 'Premium')->first(),
        ]);
    }

    /**
     * Lance la souscription Premium via Stripe Checkout (mode abonnement, test).
     */
    public function subscribe()
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->hasActiveSubscription()) {
            return back()->with('error', 'Vous avez déjà un abonnement Premium actif.');
        }

        $premium = Subscription::where('name', 'Premium')->firstOrFail();

        \Stripe\Stripe::setApiKey(config('stripe.secret_key'));

        $session = \Stripe\Checkout\Session::create([
            'mode' => 'subscription',
            'line_items' => [[
                'price' => $premium->stripe_price_id,
                'quantity' => 1,
            ]],
            'customer_email' => $user->stripe_customer_id ? null : $user->email,
            'customer' => $user->stripe_customer_id ?: null,
            'client_reference_id' => $user->id,
            'success_url' => route('account.subscription.success'),
            'cancel_url' => route('account.subscription'),
        ]);

        return redirect($session->url);
    }

    /**
     * Retour de Stripe après paiement (l'activation réelle se fait via webhook).
     */
    public function success()
    {
        return redirect()
            ->route('account.subscription')
            ->with('success', 'Merci ! Votre abonnement Premium est en cours d’activation.');
    }

    /**
     * Résilie l'abonnement Premium (immédiat, en test).
     */
    public function cancel()
    {
        /** @var User $user */
        $user = Auth::user();

        if (! $user->stripe_subscription_id) {
            return back()->with('error', 'Vous n’avez aucun abonnement à résilier.');
        }

        try {
            \Stripe\Stripe::setApiKey(config('stripe.secret_key'));
            \Stripe\Subscription::retrieve($user->stripe_subscription_id)->cancel();
        } catch (\Throwable $e) {
            return back()->with('error', 'Erreur lors de la résiliation : ' . $e->getMessage());
        }

        // Le webhook customer.subscription.deleted finalisera le retour en gratuit.
        return back()->with('success', 'Votre abonnement Premium a été résilié.');
    }
}
