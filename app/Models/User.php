<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $attributes = [
        'avatar' => '/images/default-avatar.png',
    ];

    protected $fillable = [
        'lastname',
        'firstname',
        'phone',
        'email',
        'password',
        'image_profil',
        'language',
        'reset_token',
        'notification_profil_image',
        'notification_ressources_et_formations',
        'notification_recommandation_de_produits',
        'notification_conseils_et_bonne_pratique',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'notification_profil_image' => 'boolean',
            'notification_ressources_et_formations' => 'boolean',
            'notification_recommandation_de_produits' => 'boolean',
            'notification_conseils_et_bonne_pratique' => 'boolean',
        ];
    }

    /* Un utilisateur peut posséder plusieurs commande */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /* Un utilisateur peut avoir effectué plusieurs paiement */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /* Un utilisateur peut avoir plusieurs factures */
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    /* Un utilisateur possède un abonnement unique */
    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
}
