<?php

namespace App\Models;

use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Categroy extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = ['name', 'slug'];

  protected $table = 'categroys';

public function posts()
{
    return $this->belongsToMany(Post::class, 'category_posts', 'category_id', 'post_id');
}
public function Publishposts()
{
    return $this->belongsToMany(Post::class, 'category_posts', 'category_id', 'post_id')->where('active', true)
    ->whereDate('published_at', '<=', now());
}
}
