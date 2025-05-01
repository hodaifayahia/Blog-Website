<?php

namespace App\Models;

use App\Models\Categroy;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory; // Make sure this is included

    protected $fillable = [
        'title', 'slug', 'body', 'thumbnail', 'active', 'published_at', 'user_id', 'meta_title', 'meta_description'
    ];
    protected $casts = [
        'active' => 'boolean',
        'published_at' => 'datetime'
    ];

    // Define the relationship to the User model
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Define the many-to-many relationship to the Category model
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(
            Categroy::class,
            'category_posts',
            'post_id',
            'category_id'
        );
    }
    public function ShortBody($words = 30) : string {
        return Str::limit(strip_tags( $this->body), $words);
    }
    public function GetFormattedDate() : string {
        return $this->published_at->format('F jS, Y');
    }
    public function getThumbnail()  {
        if(str_starts_with($this->thumbnail, 'https')) {
            return $this->thumbnail;
            
        }else {
            return asset('storage/' . $this->thumbnail);
        }
        
    }

    public function getReadTime(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                $wordCount = Str::wordCount(strip_tags($this->body)); // Changed from $value to $this->body
                $readTime = ceil($wordCount / 200);
                return $readTime . " " . str('min')->plural($readTime) . " ".
                      $wordCount . " " . str('word')->plural($wordCount);
            }
        );
    }
   
}
