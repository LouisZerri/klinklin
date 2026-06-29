<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'benefits',
        'stripe_price_id',
        'status',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'benefits' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /* Cette formule est-elle gratuite ? */
    public function isFree(): bool
    {
        return (int) $this->price === 0;
    }

    /* Prix mensuel formaté (ex. "19,90 € / mois" ou "Gratuit"). */
    public function priceLabel(): string
    {
        return $this->isFree()
            ? 'Gratuit'
            : number_format($this->price / 100, 2, ',', ' ') . ' € / mois';
    }

    /* Cette formule est souscrite par plusieurs utilisateurs */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
