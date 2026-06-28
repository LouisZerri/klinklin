<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
    /**
     * Profil : affichage.
     */
    public function profile()
    {
        return view('account.profile', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * Profil : mise à jour des informations.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'lastname' => ['required', 'string', 'min:2', 'max:50'],
            'firstname' => ['required', 'string', 'min:2', 'max:50'],
            'phone' => ['required', 'regex:/^\+?[0-9\s\-\(\)]+$/', 'min:7', 'max:20'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'language' => ['required', 'string', 'max:50'],
        ], [
            'lastname.min' => 'Le nom doit faire plus de 2 caractères',
            'firstname.min' => 'Le prénom doit faire plus de 2 caractères',
            'phone.regex' => 'Le numéro de téléphone doit être valide',
            'email.unique' => 'Cette adresse email est déjà utilisée',
        ]);

        $user->update($validated);

        return back()->with('success', 'Votre profil a été mis à jour.');
    }

    /**
     * Mon abonnement (template — système d'abonnement à venir).
     */
    public function subscription()
    {
        return view('account.subscription', [
            'user' => Auth::user(),
            'current' => Auth::user()->subscription,
            'plans' => Subscription::orderBy('price')->get(),
        ]);
    }

    /**
     * Notifications : affichage.
     */
    public function notifications()
    {
        return view('account.notifications', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * Notifications : mise à jour des préférences.
     */
    public function updateNotifications(Request $request)
    {
        $fields = [
            'notification_profil_image',
            'notification_ressources_et_formations',
            'notification_recommandation_de_produits',
            'notification_conseils_et_bonne_pratique',
        ];

        $data = [];
        foreach ($fields as $field) {
            $data[$field] = $request->boolean($field);
        }

        Auth::user()->update($data);

        return back()->with('success', 'Vos préférences de notification ont été enregistrées.');
    }

    /**
     * Sécurité : affichage.
     */
    public function security()
    {
        return view('account.security');
    }

    /**
     * Sécurité : changement de mot de passe.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[-@$!%*#?&]/',
            ],
        ], [
            'current_password.current_password' => 'Le mot de passe actuel est incorrect',
            'password.confirmed' => 'Les mots de passe ne correspondent pas',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères',
            'password.regex' => 'Le mot de passe doit contenir une majuscule, une minuscule, un chiffre et un caractère spécial',
        ]);

        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Votre mot de passe a été mis à jour.');
    }

    /**
     * Aide & support.
     */
    public function support()
    {
        return view('account.support');
    }

    /**
     * Politique de confidentialité (dans l'espace personnel).
     */
    public function privacy()
    {
        return view('account.privacy', config('legal.privacy'));
    }
}
