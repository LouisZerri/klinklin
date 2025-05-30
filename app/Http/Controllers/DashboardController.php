<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {

        $user = Auth::user();

        // Supprimer l'ancienne session order_id
        if (session()->has('order_id')) {
            
            $orderId = session('order_id');

            // Supprimer d'abord les order_items associés
            OrderItem::where('order_id', $orderId)->delete();

            // On passe la commande à annulé
            Order::where('id', $orderId)->update(['status' => 'Annulée']);

            // Supprimer la session
            $request->session()->forget('order_id');
        }

        return view('dashboard', compact('user'));
    } 
}
