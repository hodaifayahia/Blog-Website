<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    
    protected $fillable = [
        'title',
        'slug',
        'description',
        'image',
        'author_id',
        'publisher_id',
        'published_at',
        'isbn',
        'price',
        'stock',
    ];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'book_categoryes');
    }
}
