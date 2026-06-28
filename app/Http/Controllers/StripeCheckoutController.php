<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Order;
use App\Notifications\OrderConfirmation;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
            ->where('status', 'En attente')
            ->latest()
            ->first();

        $raw = $order->subtotal + $order->expedition + $order->tax;

        return [
            'order' => $order,
            'total' => number_format($raw, 2, ',', ' '),
            'raw' => $raw,
        ];
    }


    public function thankYou(Request $request)
    {
        $userId = Auth::id();
        
        $paidOrder = Order::where('user_id', $userId)
            ->where('status', 'En attente')
            ->latest()
            ->first();
            
        if (!$paidOrder || !session()->has('order_id')) {
            return redirect()->route('collecte');
        }

        // Envoi de la notification de confirmation de commande
        $total = number_format($paidOrder->subtotal + $paidOrder->expedition + $paidOrder->tax, 2, ',', ' ');
        $paidOrder->user->notify(new OrderConfirmation($paidOrder, $total));

        // Génère la facture PDF et l'enregistre
        $this->generateInvoice($paidOrder);

        // La commande est payée : on planifie la collecte
        $paidOrder->update(['status' => 'Prévu']);

        // Nettoie la session
        $request->session()->forget('order_id');
        
        return view('pickup.thankyou');
    }

    public function generateInvoice(Order $order)
    {
        // Charger les relations
        $order->load('orderItems.article');

        // Calcul du total
        $total = ($order->subtotal + $order->expedition + $order->tax);

        // Regrouper par article_id
        $groupedItems = $order->orderItems->groupBy('article_id')->map(function ($items) {
            
            $first = $items->first();

            return (object) [
                'article' => $first->article,
                'quantity' => $items->sum('quantity'),
                'unit_price' => $first->unit_price,
                'total' => $items->sum(fn($item) => $item->unit_price * $item->quantity),
            ];
        });

        $pdf = Pdf::loadView('invoices.invoice', [
            'order' => $order,
            'total' => $total,
            'items' => $groupedItems,
        ]);

        // Définir le chemin du fichier
        $filename = 'invoice_' . $order->id . '.pdf';
        $pdfPath = storage_path('app/public/invoices/' . $filename);

        // Sauvegarder le fichier PDF
        $pdf->save($pdfPath);


        // Enregistrer dans la base de données
        $invoice = new Invoice();
        $invoice->user_id = $order->user_id;
        $invoice->order_id = $order->id;
        $invoice->reference = 'INV-' . strtoupper(Str::random(8));
        $invoice->invoice_date = Carbon::now();
        $invoice->total = $total;
        $invoice->pdf_path = 'invoices/' . $filename;
        $invoice->save();
    }

    public function cancelOrder($orderId)
    {
        $order = Order::where('id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($order->status !== 'Prévu') {
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

            $order->status = 'Annulée';
            $order->save();

            return redirect()->route('dashboard')->with('success', 'Commande annulée et remboursée avec succès');
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'Erreur lors de l\'annulation : ' . $e->getMessage());
        }
    }
}
