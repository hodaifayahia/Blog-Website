<?php

namespace App\Models;

use \Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class TextWidget extends Model

{
    use HasFactory;
    protected $fillable = [
        'key', 'image', 'title', 'content', 'active'
    ];
    protected $casts = [
        'active' => 'boolean',
    ];
    public function getImageUrlAttribute()
    {
        if (str_starts_with($this->image, 'https')) {
            return $this->image;
        } else {
            return asset('storage/' . $this->image);
        }
    }
    public function getContentAttribute($value)
    {
        return $this->active ? $value : null;
    }
    public static function getTitle(string $value) : string
    {
        $widget =  Cache::remember('widget_title_' . $value, 10, function () use ($value) {
            return \App\Models\TextWidget::query()->where('key', $value)->Where('active', true)->first();
        });
        //  $widget = TeXTwidget::query()->where('key', $value)->Where('active', true)->first();
         return $widget ? $widget->title : '';
    }
    public static function getContent(string $value) : string
    {
         $widget =  Cache::remember('widget_content_' . $value, 10, function () use ($value) {
        return \App\Models\TextWidget::query()->where('key', $value)->Where('active', true)->first();
    });
    //  $widget = TeXTwidget::query()->where('key', $value)->Where('active', true)->first();
     return $widget ? $widget->content : '';
    }
}
