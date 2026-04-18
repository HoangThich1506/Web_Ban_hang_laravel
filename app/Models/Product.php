<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use SoftDeletes;

    protected $table = "product";

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    protected $fillable = [
        'name',
        'category_id',
        'brand_id',
        'slug',
        'price_buy',
        'price_sale',
        'image',
        'qty',
        'detail',
        'description',
        'created_by',
        'updated_by',
        'status'
    ];
}
