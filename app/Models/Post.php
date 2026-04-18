<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $table = "post";
    protected $fillable = [
        'title',
        'slug',
        'topic_id',
        'image',
        'post_type',
        'description',
        'detail',
        'created_by',
        'updated_by',
        'status'
    ];
}
