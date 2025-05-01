<?php

namespace App\Models;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'content',
        'post_id',
        'created_by',
        'user_id',
        'parent_id',
        'updated_by',
        'deleted_by',
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // has many comment 
    public function comments()
    {
        return $this->hasMany(Comment::class , 'parent_id')->orderByDesc('created_at');
    }
    // has many comment
    public function parentComment()
    {
        return $this->belongsTo(Comment::class,'parent_id');
    }
}
