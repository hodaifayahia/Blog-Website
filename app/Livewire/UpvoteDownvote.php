<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;
use App\Livewire\UpvoteDownvote;

class UpvoteDownvote extends Component
{
    public Post $post ;
    public  function mount(Post $post)
    {
        $this->post = $post;
    }

    public function render()
    {
       
        // To this:
        $upvote = \App\Models\UpvoteDownVote::where('post_id', $this->post->id)
            ->where('is_upvote', true)
            ->count();
        $downvote = \App\Models\UpvoteDownVote::where('post_id', $this->post->id)
            ->where('is_upvote', false)
            ->count();
        $user = request()->user();
        $model = \App\Models\UpvoteDownVote::where('post_id', $this->post->id)
            ->where('user_id', $user?->id)
            ->first();
        if ($model) {
            $hasUpvote = !!$model->is_upvote;
        }
    
        return view('livewire.upvote-downvote', [
            'upvote' => $upvote,
            'downvote' => $downvote,
            'hasUpvote' => $model ? $model->is_upvote : null,
            
        ]);
    }
    public function upvoteDownvote($upvote)
    {
        
            $user = request()->user();
            // 'post_id' => $this->post->id,
            // 'is_upvote' => true,
            if (!$user) {
                return redirect()->route('login');
            }
            if(!$user->hasverifiedEmail()){
                return redirect()->route('verification.notice');
            }
            $model = \App\Models\UpvoteDownVote::where('post_id', $this->post->id)
                ->where('user_id', $user->id)
                ->first();
                if (!$model) {
                    \App\Models\upvoteDownvote::create([
                        'post_id' => $this->post->id,
                        'user_id' => $user->id,
                        'is_upvote' => $upvote,
                    ]);
                    return;
                }

            if ($upvote && $model->is_upvote || !$upvote && !$model->is_upvote) {
                $model->delete();
            } else {
                $model->is_upvote = $upvote;
                $model->save();
            }

    }
    
}
