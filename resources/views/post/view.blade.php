<x-app-layout meta-title="{{ $post->meta_title ?: $post->title }}"  meta-description="{{ $post->meta_description ?:$post->title  }}" >
    <!-- Post Section -->
    <section class="w-full md:w-2/3 flex flex-col items-center px-3">
        <article class="flex flex-col shadow my-4">
            <!-- Article Image -->
            <a href="{{ route('view', $post)}}" class="hover:opacity-75">
                <img src="{{ $post->getThumbnail() }}">
            </a>
            <div class="bg-white flex flex-col justify-start p-6">
                @foreach ($post->categories as $category)
                <h1 href="#" class="text-blue-700 text-sm font-bold uppercase pb-4">
                    {{ $category->name }}
                </h1>
                @endforeach
                <a href="{{ route('view', $post)}}" class="text-3xl font-bold hover:text-gray-700 pb-4">{{ $post->title }}</a>
                <p href="{{ route('view', $post)}}" class="text-sm pb-3">
                    By <a href="#" class="font-semibold hover:text-gray-800">{{ $post->user->name }}</a>, Published on {{ $post->GetFormattedDate() }} | {{ $post->get_read_time }}
                </p>
                <p href="{{ route('view', $post)}}" class="pb-6">{!! $post->body !!}</p>

            </div>
            
            <livewire:upvote-downvote :post="$post" />
            {{-- <livewire :upvote-downvote :post="$post" /> --}}
        </article>
        
        <div class="w-full flex pt-6 gap-4">
            <div class="flex-1">
                @if ($previous)
                    <a href="{{ route('view', $previous) }}" class="block bg-white rounded-lg shadow hover:shadow-md transition-shadow p-4 hover:bg-gray-50">
                        <div class="flex items-center text-blue-600">
                            <i class="fas fa-arrow-left mr-2"></i>
                            <span class="font-bold">Previous</span>
                        </div>
                        <p class="mt-2 text-gray-600 text-sm">{{ \Illuminate\Support\Str::words($previous->title, 8) }}</p>
                    </a>
                @else
                    <div class="bg-gray-100 rounded-lg p-4 text-gray-400">
                        <div class="flex items-center">
                            <i class="fas fa-arrow-left mr-2"></i>
                            <span class="font-bold">No Older Posts</span>
                        </div>
                    </div>
                @endif
            </div>
                
            <div class="flex-1">
                @if ($next)
                    <a href="{{ route('view', $next) }}" class="block bg-white rounded-lg shadow hover:shadow-md transition-shadow p-4 hover:bg-gray-50 text-right">
                        <div class="flex items-center justify-end text-blue-600">
                            <span class="font-bold">Next</span>
                            <i class="fas fa-arrow-right ml-2"></i>
                        </div>
                        <p class="mt-2 text-gray-600 text-sm">{{ \Illuminate\Support\Str::words($next->title, 8) }}</p>
                    </a>
                @else
                    <div class="bg-gray-100 rounded-lg p-4 text-gray-400 text-right">
                        <div class="flex items-center justify-end">
                            <span class="font-bold">No Newer Posts</span>
                            <i class="fas fa-arrow-right ml-2"></i>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Comments Section -->
        <livewire:comments :post="$post" />
    </section>
    
    <!-- Use only the component tag here, not the raw HTML -->
    <x-sidebar />
</x-app-layout>