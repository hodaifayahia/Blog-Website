<article class="flex flex-col shadow my-4">
    <!-- Article Image -->
    <a href="{{ route('view', $post)}}" class="hover:opacity-75">
        <img src="{{ $post->getThumbnail() }}" class="h-64 w-full object-cover" alt="{{ $post->title }}" />
    </a>
    <div class="bg-white flex flex-col justify-start p-6">
        <div class="flex gap-2">
        @foreach ($post->categories as $category)
            <a href="#" class="text-blue-700 text-sm font-bold uppercase pb-4">
                    {{ $category->name }}
                </a>
                
                @endforeach
            </div>
        <a href="{{ route('view', $post)}}" class="text-3xl font-bold hover:text-gray-700 pb-4">{{ $post->title }}</a>
        <p href="{{ route('view', $post)}}" class="text-sm pb-3">
            By <a href="#" class="font-semibold hover:text-gray-800">{{ $post->user->name }}</a>, Published on {{ $post->GetFormattedDate() }} | {{ $post->get_read_time }}
        </p>
        <a href="{{ route('view', $post)}}" class="pb-6">{{ $post->ShortBody() }}</a>
        <a href="{{ route('view', $post)}}" class="uppercase text-gray-800 hover:text-black">Continue Reading <i class="fas fa-arrow-right"></i></a>
    </div>
</article>
