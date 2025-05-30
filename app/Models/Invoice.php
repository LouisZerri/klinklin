<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'order_id', 'reference', 'invoice_date', 'total',
    ];

    /* Cette facture est liée à une commande  */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /* Cette facture est liée à un utilisateur  */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
