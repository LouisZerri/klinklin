<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'order_number', 'address', 'complement', 'city', 'zip_code',
        'order_date', 'timeslot', 'status', 'subtotal',
        'expedition', 'tax', 'promo_code',
    ];

    protected $casts = [
        'order_date' => 'date',
        'subtotal' => 'decimal:2',
        'expedition' => 'decimal:2',
        'tax' => 'decimal:2',
    ];


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
