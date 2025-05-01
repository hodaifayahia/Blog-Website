<?php

namespace App\Livewire;

use App\Models\Comment;
use Livewire\Component;

class Commentitem extends Component
{
    public $comment;
    public $editMode = false;
    public $replayMode = false;
    protected $listeners = [
        'closeModal', 'commentUpdated' => 'closeModal',
        'commentAdded' => 'closeModal',
        'commentDeleted' => 'handleCommentDeleted',
        'childCommentDeleted' => 'refreshIfParent'
    ];
    
    // New method to refresh if this is the parent of a deleted child comment
    public function refreshIfParent($parentId, $childId)
    {
        if ($this->comment->id == $parentId) {
            // Refresh the comment with its relationships
            $this->comment = Comment::with(['user', 'comments'])->find($this->comment->id);
        }
    }
    
    public function mount(Comment $comment)
    {
        $this->comment = $comment;
    }
    
    public function render()
    {
        // Ensure we have the latest data including child comments
        if ($this->comment->parent_id === null) {
            $this->comment->load(['comments']);
        }
        
        return view('livewire.commentitem');
    }
    
    public function deleteComment()
    {
        if (!auth()->user()) {
            return redirect()->route('login');
        }
        if ($this->comment->user_id !== auth()->id()) {
            $this->addError('comment', 'You are not authorized to delete this comment.');
            return;
        }
        
        $commentId = $this->comment->id;
        $parentId = $this->comment->parent_id;
        $this->comment->delete();
        
        // Dispatch to parent Comments component
        $this->dispatch('commentDeleted', commentId: $commentId);
        
        // If this is a child comment, also dispatch a specific event for the parent comment
        if ($parentId) {
            $this->dispatch('childCommentDeleted', parentId: $parentId, childId: $commentId);
        }
    }
    
    // Handle comment deletion events
    public function handleCommentDeleted($commentId, $parentId = null)
    {
        // If this is the parent of the deleted comment, refresh
        if ($this->comment->id == $parentId) {
            $this->comment = Comment::with(['user', 'comments'])->find($this->comment->id);
            $this->dispatch('$refresh');
        }
    }
    
    public function EditComment()
    {
        $this->editMode = true;
        $this->replayMode = false;
        $this->editMode = false;
    }
    
    public function closeModal()
    {
        $this->editMode = false;
        $this->replayMode = false;
    }
    
    public function Startreplay()
    {
        $this->replayMode = true;
    }
    
    public function commentCreateed()  {
        $this->replayMode = false;
        $this->editMode = false;
    }
}
