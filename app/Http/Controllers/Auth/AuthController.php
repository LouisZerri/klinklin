<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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

    public function register(Request $request)
    {
        $request->validate([
            'lastname' => ['required', 'string', 'min:2', 'max:50'],
            'firstname' => ['required', 'string', 'min:2', 'max:50'],
            'phone' => ['required', 'regex:/^\+?[0-9\s\-\(\)]+$/', 'min:7', 'max:20'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[-@$!%*#?&]/',
            ],
        ], [
            'lastname.min' => 'Le nom doit faire plus de 2 caractères',
            'lastname.max' => 'Le nom ne peut pas dépasser 50 caractères',
            'lastname.string' => 'Le nom ne doit pas être une valeur numérique',
            'firstname.min' => 'Le prénom doit faire plus de 2 caractères',
            'firstname.max' => 'Le prénom ne peut pas dépasser 50 caractères',
            'firstname.string' => 'Le prénom ne doit pas être une valeur numérique',
            'email.unique' => 'Cette adresse email est déjà utilisée',
            'phone.min' => 'Le numéro de téléphone est trop court',
            'phone.regex' => 'Le numéro de téléphone doit être valide',
            'password.min' => 'Le mot de passe doit contenir au minimum 8 caractères',
            'password.regex' => 'Le mot de passe doit contenir une majuscule, une minuscule, un chiffre et un caractère spécial',
        ]);

        User::create([
            'lastname' => $request->lastname,
            'firstname' => $request->firstname,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);


        return redirect()->route('login')->with('success', 'Compte crée avec succès !');
    }


    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

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

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Veuillez entrer une adresse email',
            'email.email' => 'Adresse email invalide',
            'email.exists' => 'Aucun compte trouvé avec cet email',
        ]);

        // 1. Récupère l'utilisateur
        $user = User::where('email', $request->email)->first();

        // 2. Génère un token
        $token = app('auth.password.broker')->createToken($user);

        // 3. Envoie la notification personnalisée
        $user->notify(new CustomResetPassword($token));

        return back()->with('success', 'Le lien de réinitialisation a été envoyé à votre adresse email');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[-@$!%*#?&]/',
            ]
        ], [
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères',
            'password.confirmed' => 'Les mots de passe ne correspondent pas',
            'password.regex' => 'Le mot de passe doit contenir une majuscule, une minuscule, un chiffre et un caractère spécial',
        ]);

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
