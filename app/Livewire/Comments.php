<?php

namespace App\Livewire;

use App\Models\Comment;
use App\Models\Post;
use Livewire\Component;

class Comments extends Component
{
    public Post $post;
    public $comments;
    // i want to make another one for delete comment  i have the comment id and u listener form here commentDeleted
    protected $listeners = [
     'commentDeleted' => 'loadComments', // Changed from 'loadCommentsafterDelete' to 'loadComments'
     'commentAdded' => 'loadComments',
      ];

    public function mount(Post $post )
    {
        $this->post = $post;
        $this->loadComments();


    }

    public function render()
    {
        return view('livewire.comments');
    }


    public function loadComments()
    {
        $query = Comment::where('post_id', $this->post->id)
            ->with(['user', 'post', 'comments']) // Eager load relationships
            ->where('is_active', true);
        
        // Apply ordering only to parent comments
        $this->comments = $query->whereNull('parent_id')
            ->orderBy('created_at', 'desc')
            ->get();
    }
}