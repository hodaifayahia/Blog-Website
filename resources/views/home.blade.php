 <!-- Posts Section -->
 <x-app-layout  meta-description="kitablak is a webiste that u can donwload books for free">
<div class="container mx-w-3xl px-6 py-12">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        {{-- lastest Posts  --}}
        <div class="col-span-2">
            <h2 class="text-lg sm:text-xl font-bold text-blue-500 uppercase p-2 border-b-2 border-blue-500 mb-3 ">
                Lastest Posts
            </h2>
            <x-post-item :post="$latestPosts" />

        </div>
        {{-- Popular 3 Post --}}
        <div>
            <h2 class="text-lg sm:text-xl font-bold text-blue-500 uppercase p-2 border-b-2 border-blue-500 mb-3 ">
                Popular 3 Posts
            </h2>
            <div>
                @foreach ($popularPosts as $post )
                    <div class="grid grid-cols-4 gap-4">
                        <a href="{{ route('view', $post) }}" class="col-span-1">                            
                            <img src="{{ $post->getThumbnail() }}" alt="{{ $post->title }}" class="">
                        </a>
                        
                        <div class="col-span-3">
                            <div class="flex">
                                <h3 class="text-lg font-bold text-gray-800 hover:text-blue-600 whitespace-nowrap truncate">
                                    <a href="{{ route('view', $post) }}">{{ $post->title }}</a>
                                </h3>
                                <div>
                                    @foreach ($post->categories as $category)
                                    <a href="#" class="bg-blue-500 text-xs text-white font-bold uppercase p-1 mt-2 rounded ml-1">
                                            {{ $category->name }}
                                        </a>
                                        
                                        @endforeach
                                </div>
                            </div>
                            <p class="text-sm text-gray-500 mt-2">{{ $post->ShortBody(30) }}</p>
                            <a href="{{ route('view', $post)}}" class="uppercase text-gray-800 hover:text-black text-xs">Continue Reading <i class="fas fa-arrow-right"></i></a>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    {{-- Recomenened Posts  --}}

    <div>
        <h2 class="text-lg sm:text-xl font-bold text-blue-500 uppercase pd-1 border-b-2 border-blue-500 mb-3 ">
            Recomenened  Posts
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach ($recommendedPosts as $post)
                <x-post-item :post="$post" :showAuther="false" />
            @endforeach

        </div>

    </div>
    {{-- latest category --}}
    <div>
        <h2 class="text-lg sm:text-xl font-bold text-blue-500 uppercase pd-1 border-b-2 border-blue-500 mb-3 ">
            latest  Category
        </h2>
        {{-- {{ $categories }} --}}
        <div class="space-y-8">
            @foreach ($categories as $category)
                <div>
                    <h2 class="text-3xl font-bold mb-8 text-center flex items-center justify-center space-x-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        <span class="bg-blue-500 text-white px-6 py-2 rounded-lg">{{ $category->name }}</span>
                    </h2>                    <div class="grid grid-cols-1 md:grid-cols-3  gap-3">
                        @foreach ($category->Publishposts()->limit(3)->get() as $post)
                            <div >
                                <x-post-item 
                                    :post="$post" 
                                    :showAuthor="false"
                                    :class="$loop->first ? 'h-full' : ''"
                                />
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

</div>

</x-app-layout>
