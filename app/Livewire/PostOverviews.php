<?php

namespace App\Livewire;

use App\Models\PostView;
use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Model;

class PostOverviews extends Widget
{
    protected static string $view = 'livewire.post-overviews';
    // provided the colsoan full width
    protected  array|string|int $columnSpan = 'full';
    public ?Model $record = null;
    // getview data fun
    public function getViewData(): array
    {
        return [
            'ViewCount' => \App\Models\PostView::where('post_id', $this->record->id)->count(),
            'UpVotes' => \App\Models\UpvoteDownVote::where('post_id', $this->record->id)
                ->where('is_upvote', true)
                ->count(),
            'DownVotes' => \App\Models\UpvoteDownVote::where('post_id', $this->record->id)
                ->where('is_upvote', false)
                ->count(),
                
        ];
    }
    
}
