<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        return view('home', [
            'blogPosts' => BlogController::carouselPosts(),
        ]);
    }

    /**
     * Page publique de simulation de tarif (sans compte ni commande).
     */
    public function simulation()
    {
        return view('simulation', [
            'articles' => Article::all(),
            'ctaUrl' => Auth::check() ? route('collecte') : route('register'),
            'ctaLabel' => Auth::check() ? 'Planifier ma collecte' : 'Créer un compte pour commander',
            'deliveryFee' => config('pricing.expedition'),
            'taxFee' => config('pricing.tax'),
        ]);
    }
}
