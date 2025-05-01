<x-app-layout>
    <div class="min-h-screen w-full  flex flex-col items-center my-auto p-6  ">
        <div class="w-full max-w-xl   shadow-xl rounded-lg overflow-hidden">
            <div class="p-10 sm:p-8 md:p-8 lg:p-8 xl:p-8 bg-white">
                {{ $slot }}
            </div>
        </div>
    </div>
</x-app-layout>