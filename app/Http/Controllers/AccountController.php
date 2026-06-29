<?php

namespace App\Http\Controllers;

use App\Http\Requests\Account\UpdatePasswordRequest;
use App\Http\Requests\Account\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
    public function updateProfile(UpdateProfileRequest $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validated();

        // Upload de la photo de profil
        if ($request->hasFile('avatar')) {
            // Supprimer l'ancienne photo personnalisée
            if ($user->avatar && str_starts_with($user->avatar, '/images/utilisateurs/')) {
                $oldPath = public_path(ltrim($user->avatar, '/'));
                if (is_file($oldPath)) {
                    @unlink($oldPath);
                }
            }

            $file = $request->file('avatar');
            $filename = 'user_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $destination = public_path('images/utilisateurs');

            if (! is_dir($destination)) {
                mkdir($destination, 0755, true);
            }

            $file->move($destination, $filename);
            $validated['avatar'] = '/images/utilisateurs/' . $filename;
        } else {
            unset($validated['avatar']);
        }

        $user->update($validated);

        return back()->with('success', 'Votre profil a été mis à jour.');
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

        /** @var User $user */
        $user = Auth::user();
        $user->update($data);

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
    public function updatePassword(UpdatePasswordRequest $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $user->update([
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
