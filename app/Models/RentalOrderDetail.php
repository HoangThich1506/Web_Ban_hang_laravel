<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RentalOrderDetail extends Model
{
    protected $fillable = [
        'rental_order_id',
        'product_id',
        'product_name',
        'rental_price',
        'deposit_price',
        'qty',
        'size',
        'color',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(RentalOrder::class, 'rental_order_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
