<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {

        $orders = Order::where('user_id', Auth::id())->orderBy('order_date', 'asc')->get();

        return view('orders.index', [
            'orders' => $orders
        ]);
    }

    /**
     * Détails d'une commande.
     */
    public function show($id)
    {
        $order = Order::with(['orderItems.article'])
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('orders.show', [
            'order' => $order
        ]);
    }

    /**
     * Historique des commandes.
     */
    public function history()
    {
        $orders = Order::where('user_id', Auth::id())
            ->orderBy('order_date', 'desc')
            ->get();

        return view('orders.history', [
            'orders' => $orders,
        ]);
    }
}
