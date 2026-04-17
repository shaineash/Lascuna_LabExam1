<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rice extends Model
{
    protected $table = 'rices';

    protected $fillable = [
        'name',
        'price_per_kg',
        'stock_quantity',
        'description',
    ];

    protected $casts = [
        'price_per_kg' => 'decimal:2',
    ];

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
