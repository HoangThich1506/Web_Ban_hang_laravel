<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use SoftDeletes;

    protected $table = "user";

    protected $fillable = [
        'name',
        'username',
        'email',
        'phone',
        'address',
        'image',
        'password',
        'roles',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'password',
    ];
}
