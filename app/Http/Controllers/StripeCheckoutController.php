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
        
        // Stripe attend le motant en centimes
        $paymentIntent = $stripe->paymentIntents->create([
            'amount' => $total['total'] * 100,
            'currency' => 'eur',
            'automatic_payment_methods' => ['enabled' => true],
        ]);

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

        $total = number_format($order->subtotal + $order->expedition + $order->tax, 0, ',', ' ');

        $result = [
            'order' => $order,
            'total' => $total
        ];

        return $result;
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
                'unit_price' => $first->price,
                'total' => $items->sum(fn($item) => $item->price * $item->quantity),
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



}
