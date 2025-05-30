<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'image_url', 'type', 'usage', 'unit_price', 'base_weight',
    ];

    protected $casts = [
        'usage' => 'array',
        'weight_ranges' => 'array'
    ];

    /* Cette article peut être present dans plusieurs lignes de commande  */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
