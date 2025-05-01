 <!-- Posts Section -->
 <x-app-layout  meta-description="kitablak is a webiste that u can donwload books for free">

 <section class="w-full md:w-2/3 flex flex-col items-center px-3">

    @foreach ($posts as $post )
    <x-post-item :post="$post" />
    @endforeach
    
    

    <!-- Pagination -->
    {{ $posts->onEachSide(1)->links('vendor.pagination.tailwind') }}

    

</section>
<!-- Sidebar Section -->
<x-sidebar/>

</x-app-layout>
