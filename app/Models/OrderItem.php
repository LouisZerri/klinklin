<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'article_id', 'quantity', 'estimated_weight', 'unit_price',
    ];

    protected $casts = [
        'estimated_weight' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'quantity' => 'integer',
    ];

    /* Cette ligne de commande appartient à une commande */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /* Cette ligne de commande appartient à un seul article */
    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
