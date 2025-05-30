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
        'status',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'benefits' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /* Cet abonnement appartient à un utilisateur */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
