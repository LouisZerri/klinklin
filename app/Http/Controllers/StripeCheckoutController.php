<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Notifications\OrderConfirmation;
use App\Services\InvoiceService;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StripeCheckoutController extends Controller
{
    public function index()
    {
        if (!session()->has('order_id')) {
            return redirect()->route('collecte');
        }

        $total = $this->getTotal();

        return view("pickup.payment", [
            'total' => $total['total'],
            'order' => $total['order']
        ]);
    }

    public function paymentIntent()
    {  

        $stripe = new \Stripe\StripeClient(config('stripe.secret_key'));
        
        $total = $this->getTotal();

        // Stripe attend le montant en centimes (entier).
        // On part du montant numérique brut, pas de la chaîne formatée.
        $paymentIntent = $stripe->paymentIntents->create([
            'amount' => (int) round($total['raw'] * 100),
            'currency' => 'eur',
            'automatic_payment_methods' => ['enabled' => true],
        ]);

        // On conserve l'identifiant du PaymentIntent pour un éventuel remboursement.
        if ($total['order']) {
            $total['order']->update(['payment_intent_id' => $paymentIntent->id]);
        }

        return response()->json([
            'clientSecret' => $paymentIntent->client_secret
        ]);
    }

    private function getTotal()
    {
        $userId = Auth::id();

        $order = Order::where('user_id', $userId)
            ->where('status', OrderStatus::Pending)
            ->latest()
            ->first();

        $raw = $order->total;

        return [
            'order' => $order,
            'total' => number_format($raw, 2, ',', ' '),
            'raw' => $raw,
        ];
    }


    public function thankYou(Request $request, InvoiceService $invoiceService)
    {
        $orderId = session('order_id');

        $order = $orderId
            ? Order::where('id', $orderId)->where('user_id', Auth::id())->first()
            : null;

        if (! $order) {
            return redirect()->route('collecte');
        }

        // Confirme la commande seulement si le paiement a réussi.
        // Opération idempotente : le webhook a pu la confirmer avant le retour.
        if ($this->paymentSucceeded($order)) {
            $this->confirmPaidOrder($order, $invoiceService);
        }

        $request->session()->forget('order_id');

        return view('pickup.thankyou');
    }

    /**
     * Webhook Stripe : confirmation fiable du paiement (indépendante du navigateur).
     */
    public function webhook(Request $request, InvoiceService $invoiceService, SubscriptionService $subscriptionService)
    {
        try {
            $event = \Stripe\Webhook::constructEvent(
                $request->getContent(),
                $request->header('Stripe-Signature'),
                config('stripe.webhook_secret')
            );
        } catch (\Throwable $e) {
            return response('Signature invalide', 400);
        }

        switch ($event->type) {
            // Paiement d'une commande ponctuelle
            case 'payment_intent.succeeded':
                $order = Order::where('payment_intent_id', $event->data->object->id)->first();
                if ($order) {
                    $this->confirmPaidOrder($order, $invoiceService);
                }
                break;

            // Souscription Premium validée
            case 'checkout.session.completed':
                $session = $event->data->object;
                if (($session->mode ?? null) === 'subscription') {
                    $subscriptionService->activate(
                        (int) $session->client_reference_id,
                        $session->customer,
                        $session->subscription
                    );
                }
                break;

            // Abonnement résilié
            case 'customer.subscription.deleted':
                $subscriptionService->deactivate($event->data->object->id);
                break;
        }

        return response('OK', 200);
    }

    /**
     * Confirme une commande payée : notification, facture, statut.
     * Idempotent (ne fait rien si la commande n'est plus "En attente").
     */
    private function confirmPaidOrder(Order $order, InvoiceService $invoiceService): void
    {
        if ($order->status !== OrderStatus::Pending) {
            return;
        }

        $total = number_format($order->total, 2, ',', ' ');
        $order->user->notify(new OrderConfirmation($order, $total));
        $invoiceService->generateForOrder($order);
        $order->update(['status' => OrderStatus::Scheduled]);
    }

    /**
     * Vérifie auprès de Stripe que le PaymentIntent de la commande a réussi.
     */
    private function paymentSucceeded(Order $order): bool
    {
        if (! $order->payment_intent_id) {
            return false;
        }

        try {
            \Stripe\Stripe::setApiKey(config('stripe.secret_key'));

            return \Stripe\PaymentIntent::retrieve($order->payment_intent_id)->status === 'succeeded';
        } catch (\Throwable $e) {
            return false;
        }
    }

    public function cancelOrder($orderId)
    {
        $order = Order::where('id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($order->status !== OrderStatus::Scheduled) {
            return redirect()->route('dashboard')->with('error', 'La commande ne peut pas être remboursée');
        }

        try {
            \Stripe\Stripe::setApiKey(config('stripe.secret_key'));

            $paymentIntent = \Stripe\PaymentIntent::retrieve($order->payment_intent_id);
            $chargeId = $paymentIntent->latest_charge;

            if (!$chargeId) {
                return redirect()->route('dashboard')->with('error', 'Aucune charge trouvée pour ce paiement');
            }

            \Stripe\Refund::create([
                'charge' => $chargeId,
                'reason' => 'requested_by_customer',
            ]);

            $order->status = OrderStatus::Cancelled;
            $order->save();

            return redirect()->route('dashboard')->with('success', 'Commande annulée et remboursée avec succès');
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'Erreur lors de l\'annulation : ' . $e->getMessage());
        }
    }
}
