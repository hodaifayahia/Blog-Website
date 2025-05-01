<!-- Posts Section -->
<x-app-layout
    title="Search Results"
    description="Search Results">

    <section class="w-full md:w-2/3 flex flex-col items-center px-3">

        <div class="w-full grid gap-6">
            @foreach ($posts as $post)
            <div class="bg-white rounded-xl shadow p-6 border border-gray-200 hover:shadow-md transition">
                <a href="{{route('view',$post)}}">
                    <h2 class="text-xl font-semibold text-blue-500 mb-2 ">
                        {{ $post->title ?? 'Untitled Post' }}
                    </h2>
                </a>
                <p class="text-gray-700">
                    @php
                        $search = request()->get('search');
                        $shortBody = $post->shortBody(); // Fix method name
                        $highlightedBody = $search ? 
                            preg_replace('/(' . preg_quote($search, '/') . ')/i', '<span class="bg-yellow-200">$1</span>', $shortBody) : 
                            $shortBody;
                    @endphp
                    {!! $highlightedBody !!}
                </p>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        {{ $posts->onEachSide(1)->links('vendor.pagination.tailwind') }}
    </section>

    <!-- Sidebar Section -->
    <x-sidebar />
</x-app-layout>