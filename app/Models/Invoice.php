<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'order_id', 'reference', 'invoice_date', 'pdf_path', 'total',
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

     // Accessor pour l'URL du PDF
    public function getPdfUrlAttribute()
    {
        return $this->pdf_path ? asset('storage/' . $this->pdf_path) : null;
    }

    // Vérifier si le PDF existe
    public function hasPdf()
    {
        return $this->pdf_path && Storage::disk('public')->exists($this->pdf_path);
    }
}
