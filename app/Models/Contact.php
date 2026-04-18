<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use SoftDeletes;

    protected $table = 'contact';

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'title',
        'content',
        'replay_id',
        'created_at',
        'status'
    ];
}
