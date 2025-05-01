<?php

namespace App\View\Components;

use App\Models\Categroy; // You need this import
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB; // You need this import
use Illuminate\View\Component;

class Sidebar extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $categories = Categroy::query()
            ->leftjoin('category_posts', 'categroys.id', '=', 'category_posts.category_id')
            ->select('categroys.id', 'categroys.name', 'categroys.slug', DB::raw('count(*) as total'))
            ->groupBy('categroys.id', 'categroys.name', 'categroys.slug')
            ->orderByDesc('total')
            ->limit(5)
            ->get();
            
        return view('components.sidebar', compact('categories'));
    }
}