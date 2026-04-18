<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use SoftDeletes;

    protected $table = "order";

    public function orderdetails(): HasMany
    {
        return $this->hasMany(Orderdetail::class);
    }
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'address',
        'note',
        'created_at',
        'updated_by',
        'status'
    ];
}
