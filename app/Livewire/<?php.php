<?php

namespace App\Livewire;

use App\Models\UpvoteDownVote;
use App\Models\Post;
use Livewire\Component;

class UpvoteDownVoteComponent extends Component
{
    public Post $post ;
    public  function mount(Post $post)
    {
        $this->post = $post;
    }

    public function render()
    {
        $upvote = UpvoteDownVote::where('post_id', $this->post->id)->where('is_upvote', true)->count();
        $downvote = UpvoteDownVote::where('post_id', $this->post->id)->where('is_upvote', false)->count();
        return view('livewire.upvote-downvote',
            [
                'upvote' => $upvote,
                'downvote' => $downvote,
            ]);
    }
}
