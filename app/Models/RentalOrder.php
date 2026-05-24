<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RentalOrder extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'address',
        'rental_start_date',
        'rental_end_date',
        'subtotal',
        'deposit_total',
        'total',
        'status',
        'note',
    ];

    protected $casts = [
        'rental_start_date' => 'date',
        'rental_end_date' => 'date',
        'subtotal' => 'decimal:2',
        'deposit_total' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(RentalOrderDetail::class);
    }
}
