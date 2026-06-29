<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\SendResetLinkRequest;
use App\Models\User;
use App\Notifications\CustomResetPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function showForgotPassword()
    {
        return view('auth.forgotpassword');
    }

    public function showResetForm(Request $request, $token)
    {
        return view('auth.resetpassword', [
            'token' => $token,
            'email' => $request->query('email')
        ]);
    }

    public function register(RegisterRequest $request)
    {
        User::create([
            'lastname' => $request->lastname,
            'firstname' => $request->firstname,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);


        return redirect()->route('login')->with('success', 'Compte crée avec succès !');
    }


    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard')->with('success', 'Vous êtes maintenant connecté !');
        }

        return back()->withErrors([
            'email' => 'Les identifiants sont incorrects',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function sendResetLink(SendResetLinkRequest $request)
    {
        // 1. Récupère l'utilisateur
        $user = User::where('email', $request->email)->first();

        // 2. Génère un token
        $token = app('auth.password.broker')->createToken($user);

        // 3. Envoie la notification personnalisée
        $user->notify(new CustomResetPassword($token));

        return back()->with('success', 'Le lien de réinitialisation a été envoyé à votre adresse email');
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', 'Mot de passe réinitialisé avec succès !')
            : back()->withErrors(['email' => __($status)]);
    }
}
