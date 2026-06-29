<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\StripeCheckoutController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes publiques
|--------------------------------------------------------------------------
| Pages accessibles sans authentification (vitrine, contenu, pages légales).
| Les routes d'authentification sont dans routes/auth.php et les routes de
| l'application authentifiée dans routes/app.php.
*/

/* Page d'accueil */
Route::get('/', [HomeController::class, 'index'])->name('home');

/* Simulation de tarif (publique) */
Route::get('/simulation', [HomeController::class, 'simulation'])->name('simulation');

/* Pages "En savoir plus" (fonctionnalités) */
Route::get('/services/{slug}', [FeatureController::class, 'show'])->name('feature');

/* Articles & conseils (blog) */
Route::get('/conseils/{slug}', [BlogController::class, 'show'])->name('blog.show');

/* Pages statiques */
Route::get('/centre-aide', [PageController::class, 'help'])->name('help');
Route::get('/confidentialite', [PageController::class, 'privacy'])->name('privacy');
Route::get('/conditions', [PageController::class, 'terms'])->name('terms');

/* Webhook Stripe (authentifié par signature, hors CSRF) */
Route::post('/stripe/webhook', [StripeCheckoutController::class, 'webhook'])->name('stripe.webhook');

/*
| Routes regroupées par domaine (chargées avec le même groupe "web").
*/
require __DIR__.'/auth.php';
require __DIR__.'/app.php';
