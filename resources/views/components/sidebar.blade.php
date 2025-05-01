<aside class="w-full md:w-1/3 flex flex-col items-center px-3">
    <div class="w-full bg-white shadow flex flex-col my-4 p-6">
        <p class="text-xl font-semibold pb-5">Categories</p>
        <ul>
            @foreach ($categories as $category)
                <li class="pb-2">
                    <a href="{{ route('by-category', $category) }}" class=" text-sm font-bold uppercase px-6 {{ (request('category')->slug ?? null) == $category->slug ? 'bg-blue-500 text-white p-2' : '' }}">
                        {{ $category->name }} ({{ $category->total }})
                    </a>
                </li>
            @endforeach
        </ul>
        <a href="#" class="w-full bg-blue-800 text-white font-bold text-sm uppercase rounded hover:bg-blue-700 flex items-center justify-center px-2 py-3 mt-4">
            View all categories
        </a>
    </div>
    
    <div class="w-full bg-white shadow flex flex-col my-4 p-6">
        <p class="text-xl font-semibold pb-5">About Us</p>
        <p class="pb-2">{{ App\Models\TextWidget::getTitle('get-sidebar')}}</p>
        <p class="pb-2">{!! App\Models\TextWidget::getContent('get-sidebar') !!}</p>
        <a href="#" class="w-full bg-blue-800 text-white font-bold text-sm uppercase rounded hover:bg-blue-700 flex items-center justify-center px-2 py-3 mt-4">
            Get to know us
        </a>
    </div>
</aside>