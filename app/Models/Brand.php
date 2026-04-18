<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use SoftDeletes;

    protected $table = 'brand';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'status',
        'image',
        'created_by',
        'updated_by'
    ];
}
