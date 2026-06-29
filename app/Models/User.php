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
        'avatar',
        'image_profil',
        'language',
        'reset_token',
        'notification_profil_image',
        'notification_ressources_et_formations',
        'notification_recommandation_de_produits',
        'notification_conseils_et_bonne_pratique',
        'subscription_id',
        'stripe_customer_id',
        'stripe_subscription_id',
        'subscription_status',
        'subscription_ends_at',
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
            'subscription_ends_at' => 'datetime',
        ];
    }

    /* L'utilisateur a-t-il un abonnement payant actif ? */
    public function hasActiveSubscription(): bool
    {
        return $this->subscription_status === 'active'
            && ! is_null($this->stripe_subscription_id);
    }

    /* Un utilisateur peut posséder plusieurs commande */
    public function orders()
    {
        return $this->hasMany(Order::class);
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
