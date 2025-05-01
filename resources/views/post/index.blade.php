<!-- Posts Section -->
<x-app-layout 
    meta-title="{{ $Category->name }} Books - Free Downloads | Kitablak" 
    meta-description="Browse our collection of {{ $Category->name }} books available for free download. Discover bestsellers, classics, and new releases in this category."
>

    <section class="w-full md:w-2/3 flex flex-col items-center px-3">
        <h1 class="text-3xl font-bold my-6 text-gray-800">{{ $Category->name }} Books</h1>
        
        <div class="w-full grid gap-6">
            @foreach ($posts as $post)
                <x-post-item :post="$post" />
            @endforeach
        </div>
        
        <!-- Pagination -->
        {{ $posts->onEachSide(1)->links('vendor.pagination.tailwind') }}
    </section>
    
    <!-- Sidebar Section -->
    <x-sidebar />
</x-app-layout>