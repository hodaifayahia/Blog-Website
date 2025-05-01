<?php

namespace App\Livewire;

use App\Models\Comment;
use App\Models\Post;
use Livewire\Component;

class CreateComment extends Component
{
    public $comment = '';
    public Post $post;

    protected $rules = [
        'comment' => 'required|min:5|max:255',
    ];

    protected $messages = [
        'comment.required' => 'The comment cannot be empty.',
        'comment.min' => 'The comment must be at least 5 characters.',
        'comment.max' => 'The comment cannot exceed 255 characters.',
    ];
    // createa aa commment model
    public ?Comment $commentModel = null;
    public $parentComment = null;

    public function mount(Post $post , $commentModel = null, $parentComment = null)
    {
        $this->commentModel = $commentModel;
        $this->comment = $commentModel?->content ?? '';
        $this->post = $post;
        $this->parentComment = $parentComment;
    }

    public function render()
    {
        return view('livewire.create-comment');
    }
    public function submitComment()
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Validate input
        $this->validate();

        if ($this->commentModel) {
            // Check if user is authorized to edit the comment
            if ($this->commentModel->user_id !== auth()->id()) {
                $this->addError('comment', 'You are not authorized to edit this comment.');
                return;
            }

            // Update existing comment
            $this->commentModel->update([
                'content' => $this->comment,
            ]);

            // Emit event to parent component
            $this->dispatch('commentUpdated', commentId: $this->commentModel->id);
            return;
        }

        // Create new comment
        $comment = Comment::create([
            'content' => $this->comment,
            'user_id' => auth()->id(),
            'post_id' => $this->post->id,
            'is_active' => true,
            'parent_id' => $this->parentComment ?? null,
        ]);
    
        // Emit event to parent component - using dispatch without parameters
        $this->dispatch('commentAdded');
        
        // Reset the comment field
        $this->comment = '';
    }
   
}