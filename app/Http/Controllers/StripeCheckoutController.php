<?php

namespace App\Http\Controllers;

use App\Models\Order;
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
        
        $request->session()->forget('order_id');
        
        return view('pickup.thankyou');
    }



}
