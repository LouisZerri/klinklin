<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'order_number', 'address', 'complement', 'city', 'zip_code',
        'order_date', 'timeslot', 'status', 'payment_intent_id', 'subtotal',
        'discount', 'expedition', 'tax', 'promo_code',
    ];

    protected $casts = [
        'order_date' => 'date',
        'status' => OrderStatus::class,
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'expedition' => 'decimal:2',
        'tax' => 'decimal:2',
    ];

    /* Expose le total calculé dans la sérialisation JSON (composants Vue). */
    protected $appends = ['total'];

    /* Total de la commande : sous-total − remise + livraison + taxe. */
    protected function total(): Attribute
    {
        return Attribute::make(
            get: fn () => (float) $this->subtotal - (float) $this->discount + (float) $this->expedition + (float) $this->tax,
        );
    }


    /* Une commande appartient à un seul utilisateur */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /* Une commande peut contenir plusieurs lignes d'articles */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /* Une commande possède une facture */
    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}
