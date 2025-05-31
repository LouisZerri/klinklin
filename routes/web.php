<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PickupController;
use App\Http\Controllers\StripeCheckoutController;
use Illuminate\Support\Facades\Route;


/* Page d'accueil */
Route::get('/', function () {
    return view('home');
});



/* Authentification */
Route::get('register', [AuthController::class, 'showRegister'])->name('register');
Route::post('register', [AuthController::class, 'register'])->name('post_register');

Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('post_login');

Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('forgotpassword');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('post_sendresetlink');

Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('resetpassword');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('post_resetpassword');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



/* ====================== PLANIFICATION D'UNE COMMANDE ====================== */

/* Planification de la collecte */
Route::get('/collecte', [PickupController::class, 'index'])->middleware(['auth', 'verified'])->name('collecte');
Route::post('/collecte', [PickupController::class, 'storeAddress'])->middleware(['auth', 'verified'])->name('post_address');

/* Selection des articles */
Route::get('/collecte/articles', [PickupController::class, 'selectArticles'])->middleware(['auth', 'verified'])->name('articles');
Route::post('/collecte/articles', [PickupController::class, 'storeArticles'])->middleware(['auth', 'verified'])->name('post_articles');

/* Récapitulatif de la commande */
Route::get("/collecte/recapitulatif", [PickupController::class, 'showResume'])->middleware(['auth', 'verified'])->name('collecte_resume');
Route::post('order/update-infos', [PickupController::class, 'updateInfos'])->name('order.update-info');

/* Paiement de la commande */
Route::get("/collecte/paiement", [StripeCheckoutController::class, 'index'])->middleware(['auth', 'verified'])->name('checkout.index');
Route::post("/collecte/paiement", [StripeCheckoutController::class, 'paymentIntent'])->middleware(['auth', 'verified'])->name('checkout.paymentIntent');
Route::get('/thankyou', [StripeCheckoutController::class, 'thankYou'])->middleware(['auth', 'verified'])->name('checkout.thankyou');

/* ====================== LES COMMANDES ====================== */

Route::get("/commandes", [OrderController::class, 'index'])->middleware(['auth', 'verified'])->name('orders.index');

/* ====================== LES FACTURES ====================== */

Route::get("/factures", [InvoiceController::class, 'index'])->middleware(['auth', 'verified'])->name('invoices.index');

/* Télécharger une facture */
Route::get('/factures/{id}/download', [InvoiceController::class, 'download'])->middleware(['auth', 'verified'])->name('invoices.download');

/* Visualiser une facture */
Route::get('/factures/{id}/view', [InvoiceController::class, 'view'])->middleware(['auth', 'verified'])->name('invoices.view');

/* Vérifier la disponibilité d'une facture */
Route::get('/factures/{id}/check', [InvoiceController::class, 'checkAvailability'])->middleware(['auth', 'verified'])->name('invoices.check');










/* Page du tableau de bord */
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
