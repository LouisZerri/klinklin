<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PickupController extends Controller
{
    public function index(Request $request)
    {
        // Supprimer l'ancienne session order_id
        if (session()->has('order_id')) {
            
            $orderId = session('order_id');

            // Supprimer d'abord les order_items associés
            OrderItem::where('order_id', $orderId)->delete();

            // Supprimer la commande elle-même
            Order::where('id', $orderId)->delete();

            // Supprimer la session
            $request->session()->forget('order_id');
        }

        return view('pickup.collecte');
    }

    /* On stocke d'abord en sesion l'adresse de la commande */
    public function storeAddress(Request $request)
    {
        $validated = $request->validate([
            'address' => 'string|min:5|max:255',
            'complement' => 'nullable|string|max:255',
            'city' => 'string|regex:/^[\pL\s\-]+$/u|max:100',
            'zip_code' => 'string|regex:/^[A-Za-z0-9\s\-]+$/u|max:20',
            'order_date' => 'date|after_or_equal:today',
            'timeslot' => 'string'
        ], [
            'address.min' => 'L’adresse doit contenir au moins :min caractères',
            'address.max' => 'L’adresse ne peut pas dépasser :max caractères',

            'complement.max' => 'Le complément d’adresse ne peut pas dépasser :max caractères',

            'city.regex' => 'La ville ne peut contenir que des lettres, des espaces et des tirets',
            'city.max' => 'La ville ne peut pas dépasser :max caractères',

            'zip_code.regex' => 'Le code postal ne peut contenir que des lettres, chiffres, espaces et tirets',

            'order_date.date' => 'La date de commande doit être une date valide',
            'order_date.after_or_equal' => 'La date de commande ne peut pas être antérieure à aujourd’hui'
        ]);

        $order = Order::create([
            ...$validated,
            'user_id' => Auth::id(),
            'order_number' => $this->generateOrderNumber(),
            'status' => 'En attente',
            'subtotal' => 0,
            'expedition' => 10,
            'tax' => 5,
        ]);

        if ($order) {
            // Créer une nouvelle session avec la nouvelle order_id
            $request->session()->put('order_id', $order->id);

            // Alternative: forcer la sauvegarde immédiate de la session
            $request->session()->save();
        }

        return redirect()->route('articles');
    }


    /* Ensuite on fait la même chose avec les articles */
    public function selectArticles()
    {
        if (!session()->has('order_id')) {
            return redirect()->route('collecte');
        }

        $articles = Article::all();

        return view('pickup.articles', [
            'articles' => $articles,
            'postArticlesUrl' => route('post_articles'),
            'cancelUrl' => route('collecte'), 
            'csrfToken' => csrf_token()
        ]);
    }

    public function storeArticles(Request $request)
    {
        $items = json_decode($request->input('articles_data'), true);
        $orderId = session('order_id');

        if (!$orderId) {
            return redirect()->route('collecte');
        }

        $subtotal = 0;

        foreach ($items as $item) {

            $lineTotal = $item['unit_price'] * $item['quantity'];
            $subtotal += $lineTotal;

            OrderItem::create([
                'order_id' => $orderId,
                'article_id' => $item['article_id'],
                'name' => $item['name'],
                'quantity' => $item['quantity'],
                'estimated_weight' => $item['avg_weight'],
                'unit_price' => $item['unit_price']
            ]);
        }

        // Mise à jour du total dans la commande
        $order = Order::findOrFail($orderId);
        $order->subtotal = $subtotal;
        $order->save();

        return redirect()->route('collecte_resume');
    }

    public function showResume()
    {
        if (!session()->has('order_id')) {
            return redirect()->route('collecte');
        }

        $orderId = session('order_id');

        $items = DB::table('order_items')
            ->join('articles', 'order_items.article_id', '=', 'articles.id')
            ->select(
                'articles.name as article_name',
                'order_items.quantity',
                'order_items.estimated_weight',
                'order_items.unit_price',
            )
            ->where('order_items.order_id', $orderId)
            ->get();

        $order = Order::findOrFail($orderId);

        return view('pickup.recapitulatif', compact('items', 'order'));
    }

    public function updateInfos(Request $request)
    {
        $validated = $request->validate([
            'order_date' => 'required|date|after_or_equal:today',
            'timeslot' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'complement' => 'nullable|string|max:255',
            'zip_code' => 'required|string|max:20',
            'city' => 'required|string|max:100'
        ]);

        $orderId = session('order_id');

        if (!$orderId) {
            return response()->json(['error' => 'Session expirée ou invalide'], 403);
        }

        $order = Order::findOrFail($orderId);
        $order->order_date = $validated['order_date'];
        $order->timeslot = $validated['timeslot'];
        $order->address = $validated['address'];
        $order->complement = $validated['complement'];
        $order->zip_code = $validated['zip_code'];
        $order->city = $validated['city'];

        $order->save();
 
        return response()->json(['success' => true]);
    }


    public function cancelArticles()
    {
        $orderId = session('order_id');

        if ($orderId) {
            OrderItem::where('order_id', $orderId)->delete();
        }

        $previousUrl = url()->previous();

        if (str_contains($previousUrl, 'recapitulatif')) {
            return redirect()->route('articles');
        }

        return redirect()->route('collecte');
    }

    private function generateOrderNumber() {
        $number = str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
        return '#' . $number;
    }
}
