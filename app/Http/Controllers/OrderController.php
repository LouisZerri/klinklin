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
