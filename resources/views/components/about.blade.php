<x-app-layout 
    meta_title="About Kitablak - Free Book Downloads | Your Digital Library" 
    meta_description="Discover Kitablak - your free online library. Download thousands of books in various formats. Read anytime, anywhere with our vast collection of free eBooks."
>    <!-- Main Container -->
    <div class="container mx-auto px-4 py-8 max-w-5xl">
        <!-- Article Card -->
        <article class="bg-white shadow-lg rounded-lg overflow-hidden">
            <!-- Article Image (Responsive with Lazy Loading) -->
            <div class="w-full aspect-w-16 aspect-h-9 lg:aspect-h-6 bg-gray-100">
                <img 
                    src="{{ $widget->getImageUrlAttribute() }}" 
                    alt="{{ $widget->title }}"
                    class="w-full h-full object-cover"
                    loading="lazy"
                >
            </div>

            <!-- Content Section -->
            <div class="p-6 md:p-8">
                <!-- Title -->
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4 leading-tight">
                    {{ $widget->title }}
                </h1>

                <!-- Content (Improved Typography) -->
                <div class="prose prose-lg max-w-none text-gray-700">
                    {!! $widget->content !!}
                </div>

                <!-- Optional Metadata (Date, Author, etc.) -->
                <div class="mt-6 pt-6 border-t border-gray-100 text-sm text-gray-500">
                    Published on {{ $widget->created_at->format('F j, Y') }}
                </div>
            </div>
        </article>
    </div>
</x-app-layout>