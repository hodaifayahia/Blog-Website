<div class="w-full">
    <livewire:create-comment :post="$post"  />

    <div class="max-w-full mx-auto p-4 bg-white rounded-lg shadow">
        @foreach($comments as $comment)
            <livewire:commentitem :comment="$comment" wire:key="comment{{ $comment->id }}"  />
        @endforeach
    </div>

</div>
