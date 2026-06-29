<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {

        $user = Auth::user();

        // Supprimer l'ancienne commande non finalisée (jamais payée) plutôt
        // que de la laisser en "Annulée" et polluer l'historique.
        if (session()->has('order_id')) {

            $order = Order::find(session('order_id'));

            // On ne supprime qu'une commande non payée (statut En attente).
            // Les commandes payées puis remboursées restent en "Annulée".
            if ($order && $order->status === OrderStatus::Pending) {
                $order->delete(); // supprime aussi les order_items (cascade)
            }

            $request->session()->forget('order_id');
        }

        return view('dashboard', compact('user'));
    }

    public function showActivities()
    {
        $userId = Auth::id();

        $excluded = [OrderStatus::Cancelled->value, OrderStatus::Delivered->value];

        $ordersInProgress = Order::where('user_id', $userId)
            ->whereNotIn('status', $excluded)
            ->count();

        $latestPayments = Order::where('user_id', $userId)
            ->whereNotIn('status', $excluded)
            ->sum(DB::raw('subtotal + expedition + tax'));

        $invoices = Invoice::where('user_id', $userId)->count();

        return view('dashboard.activities', [
            'ordersInProgress' => $ordersInProgress,
            'latestPayments' => $latestPayments,
            'invoices' => $invoices,
        ]);
    }

    public function showTransactions()
    {
        $orders = DB::table('orders')
            ->join('invoices', 'orders.id', '=', 'invoices.order_id')
            ->leftJoin('order_items', 'orders.id', '=', 'order_items.order_id')
            ->select(
                'orders.id as order_id',
                'invoices.reference as invoice_reference',
                'invoices.invoice_date',
                'orders.order_date',
                DB::raw('(orders.subtotal + orders.expedition + orders.tax) as total_amount'),
                DB::raw('SUM(order_items.quantity) as total_quantity')
            )
            ->where('orders.user_id', Auth::id())
            ->where('orders.subtotal', '!=', 0)
            ->groupBy(
                'orders.id',
                'invoices.reference',
                'invoices.invoice_date',
                'orders.order_date',
                'orders.subtotal',
                'orders.expedition',
                'orders.tax'
            )
            ->get();

        return view('dashboard.transactions', [
            'orders' => $orders
        ]);
    }
}
