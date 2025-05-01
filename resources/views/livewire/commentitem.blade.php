<div class="flex p-4 border-b border-gray-200">
    <!-- User avatar on the left -->
    <div class="mr-3 flex-shrink-0">
        <img src="{{ $comment->user->avatar_url ?? 'https://via.placeholder.com/40' }}" 
             alt="{{ $comment->user->name }}"
             class="w-10 h-10 rounded-full object-cover">
    </div>
    
    <!-- Comment content on the right -->
    <div class="flex-1">
        <div class="flex items-center mb-1">
            <span class="font-semibold text-gray-800 mr-2">{{ $comment->user->name }}</span>
            <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
        </div>
        @if ($editMode)
        <livewire:create-comment  :comment-model="$comment" />
        @else
        <p class="text-gray-700 mb-2">{{ $comment->content }}</p>
        @endif
        
        <!-- Comment actions -->
        <div class="flex items-center text-xs space-x-4 text-gray-500">
            <button wire:click.prevent="Startreplay" class="hover:text-blue-500">Reply</button>
            {{-- <button class="hover:text-red-500">Like</button> --}}
            @if ($comment->user_id == auth()->id())
            <button  wire:click.prevent="EditComment" class="hover:text-blue-500">Edit</button>
            <button wire:click.prevent="deleteComment" class="hover:text-red-500">Delete</button>
            @endif
            <span class="text-gray-400">3 likes</span>

        </div>
        @if ($replayMode)
        <div class="ml-4 mt-2">
            {{-- <livewire:commentitem :replay-mode="true"  /> --}}
            <livewire:create-comment :post="$comment->post" parent-comment="{{ $comment->id }}" />
        </div>
        @endif
        @if($comment->comments->count() > 0)
            @foreach ($comment->comments as $reply)
            <livewire:commentitem :comment="$reply" :key="$reply->id" />
            @endforeach
        @endif

    </div>
</div>