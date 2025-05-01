<?php

namespace App\Http\Controllers;

use App\Models\TextWidget;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function about()
    {
        // This method will return the view for the about us page
        $widget = TextWidget::query()
            ->where('active', true)
            ->where('key', 'about-page')
            ->first();
        if(!$widget) {
            abort(404);
        }
        

        return view('components.about',compact('widget'));
    }
}
