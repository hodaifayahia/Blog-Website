<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auther extends Model
{
    protected $table = 'authors';
    protected $fillable = [
        'name',
        'slug',
        'bio',
        'image',
    ];

    public function books()
    {
        return $this->hasMany(Book::class);
    }

    public function getImageUrlAttribute()
    {
        if (str_starts_with($this->image, 'https')) {
            return $this->image;
        } else {
            return asset('storage/' . $this->image);
        }
    }
}
