<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PickupController;
use App\Http\Controllers\StripeCheckoutController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes de l'application authentifiée
|--------------------------------------------------------------------------
| Tout ce qui nécessite d'être connecté et vérifié : parcours de commande,
| commandes, factures, tableau de bord et espace personnel.
*/

Route::middleware(['auth', 'verified'])->group(function () {

    /* ============== PLANIFICATION D'UNE COMMANDE ============== */

    // Planification de la collecte
    Route::get('/collecte', [PickupController::class, 'index'])->name('collecte');
    Route::post('/collecte', [PickupController::class, 'storeAddress'])->name('post_address');

    // Sélection des articles
    Route::get('/collecte/articles', [PickupController::class, 'selectArticles'])->name('articles');
    Route::post('/collecte/articles', [PickupController::class, 'storeArticles'])->name('post_articles');

    // Récapitulatif de la commande
    Route::get('/collecte/recapitulatif', [PickupController::class, 'showResume'])->name('collecte_resume');
    Route::post('order/update-infos', [PickupController::class, 'updateInfos'])->name('order.update-info');

    // Paiement de la commande
    Route::get('/collecte/paiement', [StripeCheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/collecte/paiement', [StripeCheckoutController::class, 'paymentIntent'])->name('checkout.paymentIntent');
    Route::get('/thankyou', [StripeCheckoutController::class, 'thankYou'])->name('checkout.thankyou');

    /* ============== LES COMMANDES ============== */

    Route::get('/commandes', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/commandes/historique', [OrderController::class, 'history'])->name('orders.history');
    Route::get('/commandes/{id}', [OrderController::class, 'show'])->whereNumber('id')->name('orders.show');
    Route::post('/commandes/{id}/annuler', [StripeCheckoutController::class, 'cancelOrder'])->name('order.cancel');

    /* ============== LES FACTURES ============== */

    Route::get('/factures', [InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('/factures/telecharger-tout', [InvoiceController::class, 'downloadAll'])->name('invoices.download_all');
    Route::get('/factures/{id}/download', [InvoiceController::class, 'download'])->name('invoices.download');
    Route::get('/factures/{id}/view', [InvoiceController::class, 'view'])->name('invoices.view');
    Route::get('/factures/{id}/check', [InvoiceController::class, 'checkAvailability'])->name('invoices.check');

    /* ============== TABLEAU DE BORD ============== */

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/activites', [DashboardController::class, 'showActivities'])->name('dashboard.activities');
    Route::get('/dashboard/transactions', [DashboardController::class, 'showTransactions'])->name('dashboard.transactions');

    /* ============== ESPACE PERSONNEL ============== */

    Route::prefix('compte')->name('account.')->group(function () {
        Route::get('/profil', [AccountController::class, 'profile'])->name('profile');
        Route::put('/profil', [AccountController::class, 'updateProfile'])->name('profile.update');

        Route::get('/abonnement', [SubscriptionController::class, 'index'])->name('subscription');
        Route::post('/abonnement/souscrire', [SubscriptionController::class, 'subscribe'])->name('subscription.subscribe');
        Route::get('/abonnement/succes', [SubscriptionController::class, 'success'])->name('subscription.success');
        Route::post('/abonnement/annuler', [SubscriptionController::class, 'cancel'])->name('subscription.cancel');

        Route::get('/securite', [AccountController::class, 'security'])->name('security');
        Route::put('/securite', [AccountController::class, 'updatePassword'])->name('security.update');

        Route::get('/notifications', [AccountController::class, 'notifications'])->name('notifications');
        Route::put('/notifications', [AccountController::class, 'updateNotifications'])->name('notifications.update');

        Route::get('/aide', [AccountController::class, 'support'])->name('support');
        Route::get('/confidentialite', [AccountController::class, 'privacy'])->name('privacy');
    });
});
