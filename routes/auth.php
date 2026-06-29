<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes d'authentification
|--------------------------------------------------------------------------
| Inscription, connexion, mot de passe oublié / réinitialisation, déconnexion.
*/

Route::get('register', [AuthController::class, 'showRegister'])->name('register');
Route::post('register', [AuthController::class, 'register'])->name('post_register');

Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('post_login');

Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('forgotpassword');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('post_sendresetlink');

Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('resetpassword');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('post_resetpassword');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
