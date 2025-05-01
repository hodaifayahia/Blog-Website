<article class="flex flex-col shadow-lg hover:shadow-xl transition-shadow duration-300 rounded-lg overflow-hidden bg-white my-6">
    <!-- Article Image -->
    <a href="{{ route('view', $post) }}" class="block overflow-hidden">
        <img src="{{ $post->getThumbnail() }}" 
             class="w-full h-64 object-cover hover:scale-105 transition-transform duration-500">
    </a>
    
    <div class="p-6 flex flex-col h-full">
        <!-- Categories -->
        <div class="flex flex-wrap gap-2 mb-4">
            @foreach ($post->categories as $category)
                <a href="{{ route('category.show', $category) }}" 
                   class="px-3 py-1 bg-blue-50 text-blue-700 text-xs font-semibold uppercase rounded-full hover:bg-blue-100 transition-colors">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>
        
        <!-- Title -->
        <a href="{{ route('view', $post) }}" class="text-2xl lg:text-3xl font-bold text-gray-900 hover:text-blue-600 mb-3 transition-colors">
            {{ $post->title }}
        </a>
        
        <!-- Meta -->
        <div class="flex items-center text-sm text-gray-500 mb-4 space-x-2">
            <a href="{{ route('author.show', $post->user) }}" class="flex items-center hover:text-gray-800 group">
                <span class="w-6 h-6 rounded-full bg-gray-200 mr-2 overflow-hidden">
                    @if($post->user->profile_photo)
                        <img src="{{ $post->user->profile_photo }}" class="w-full h-full object-cover">
                    @else
                        <span class="flex items-center justify-center text-xs text-gray-600">
                            {{ substr($post->user->name, 0, 1) }}
                        </span>
                    @endif
                </span>
                <span class="font-medium group-hover:underline">{{ $post->user->name }}</span>
            </a>
            <span>•</span>
            <span>{{ $post->GetFormattedDate() }}</span>
            <span>•</span>
            <span>{{ $post->get_read_time }}</span>
        </div>
        
        <!-- Excerpt -->
        <div class="text-gray-600 mb-5 line-clamp-3">
            {{ $post->ShortBody() }}
        </div>
        
        <!-- CTA -->
        <div class="mt-auto">
            <a href="{{ route('view', $post) }}" 
               class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium group transition-colors">
                Continue Reading
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </a>
        </div>
    </div>
</article>