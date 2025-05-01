<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $metaTitle ?: "kitablak blog" }}</title>
    <meta name="author" content="kitablak">
    <meta name="description" content="{{ $metaDescription ?: " " }}">

    <!-- Tailwind -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8fafc;
        }

        .nav-link {
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-link:hover {
            transform: translateY(-2px);
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -4px;
            left: 0;
            background-color: #3b82f6;
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .header-title {
            transition: color 0.3s ease;
            letter-spacing: 0.05em;
        }

        .dropdown-menu {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            border-radius: 0.5rem;
            transform-origin: top right;
            transition: all 0.2s ease;
        }

        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .btn {
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
    </style>

    <!-- AlpineJS - Moved to top to ensure it loads first -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 min-h-screen flex flex-col">

    <!-- Text Header -->
    <header class="w-full bg-white shadow-sm">
        <div class="container mx-auto flex flex-col items-center py-4">
            <a class="header-title font-bold text-gray-800 uppercase hover:text-blue-600 text-5xl" href="{{ route('home') }}">
                {{ App\Models\TextWidget::getTitle('header') }}
            </a>
            <p class="text-lg text-gray-600 mt-2">
                {{!! App\Models\TextWidget::getContent('header') !!}}
            </p>
        </div>
    </header>

    <!-- Topic Nav -->
    <nav class="w-full py-4 border-t border-b bg-white shadow-md sticky top-0 z-10">
        <div x-data="{ open: false }" class="container mx-auto px-6">
            <!-- Mobile Navigation Button -->
            <div class="block sm:hidden">
                <button
                    @click="open = !open"
                    class="flex items-center px-3 py-2 border rounded text-blue-500 border-blue-500 hover:text-blue-700 hover:border-blue-700 btn">
                    <svg class="fill-current h-4 w-4" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <title>Menu</title>
                        <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" />
                    </svg>
                    <span class="ml-2">Menu</span>
                </button>
            </div>


            <!-- Navigation Links -->
            <div :class="{'block': open, 'hidden': !open}" class="w-full sm:flex sm:justify-between sm:items-center sm:w-auto mt-4 sm:mt-0">
                <div class="text-sm flex flex-row   sm:justify-start">
                    <a href="{{ route('home') }}" class="block mt-4 sm:inline-block sm:mt-0 text-gray-700 hover:text-blue-600 mr-6 nav-link">
                        Home
                    </a>

                    @foreach ($categories as $category)
                    <a href="{{ route('by-category', $category) }}" class="block mt-4 sm:inline-block sm:mt-0 text-gray-700 hover:text-blue-600 mr-6 nav-link {{ (request('category')->slug ?? null) == $category->slug ? 'font-bold text-blue-600' : '' }}">
                        {{ $category->name }}
                    </a>
                    @endforeach

                    <a href="{{ route('about-us') }}" class="block mt-4 sm:inline-block sm:mt-0 text-gray-700 hover:text-blue-600 mr-6 nav-link">
                        About Us
                    </a>
                </div>

                <!-- Auth Navigation -->
                <div class="sm:block mt-4 sm:mt-0 flex flex-col sm:flex-row items-start sm:items-center space-y-2 sm:space-y-0 sm:space-x-4">
                    @auth
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-200 btn">
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div x-show="open"
                            @click.away="open = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform scale-95"
                            x-transition:enter-end="opacity-100 transform scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 transform scale-100"
                            x-transition:leave-end="opacity-0 transform scale-95"
                            class="dropdown-menu absolute right-0 mt-2 py-2 w-48 bg-white rounded-lg shadow-xl"
                            style="display: none;">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">
                                <i class="fas fa-user-circle mr-2"></i> Profile
                            </a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-gray-800 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                    @else
                    <a href="{{ route('login') }}" class="px-4 py-2 text-gray-700 hover:text-blue-600 nav-link"><i class="fas fa-sign-in-alt mr-1"></i> Login</a>
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-200 btn"><i class="fas fa-user-plus mr-1"></i> Register</a>
                    @endauth
                </div>
            </div>
            <div class="">
                <div class="max-w-xl mx-auto">
                    <form action="{{ route('search') }}" method="GET" class="relative">
                        <label for="search" class="sr-only">Search articles</label>
                        <div class="flex items-center border border-gray-300 rounded-lg shadow-sm focus-within:ring-2 focus-within:ring-blue-300 focus-within:border-blue-300 bg-white">
                            <span class="pl-4 text-gray-400 px-2">
                                <i class="fas fa-search"></i>
                            </span>
                            <input
                                type="text"
                                id="search"
                                name="search"
                                value="{{ request('search') }}"
                                class="w-full px-4 py-3 text-gray-800 bg-transparent focus:outline-none"
                                placeholder="Search articles...">
                            <button
                                type="submit"
                                class="px-4 py-4 text-white bg-blue-600 hover:bg-blue-700 rounded-r-lg transition">
                                Search
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </nav>

    <!-- Search Bar -->


    <!-- Main Content -->
    <div class="container mx-auto flex-grow px-6 ">
        {{ $slot }}
    </div>

    <!-- Footer -->
    <footer class="w-full border-t bg-white mt-12">
        <div class="container mx-auto px-6 pt-10 pb-6">
            <div class="flex flex-wrap">
                <div class="w-full md:w-1/4 text-center md:text-left mb-6 md:mb-0">
                    <h5 class="uppercase mb-6 font-bold text-gray-700">Links</h5>
                    <ul class="mb-4">
                        <li class="mt-2">
                            <a href="{{ route('home') }}" class="hover:underline text-gray-600 hover:text-blue-600 flex items-center md:inline-flex">
                                <i class="fas fa-home mr-2"></i> Home
                            </a>
                        </li>
                        <li class="mt-2">
                            <a href="{{ route('about-us') }}" class="hover:underline text-gray-600 hover:text-blue-600 flex items-center md:inline-flex">
                                <i class="fas fa-info-circle mr-2"></i> About Us
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="w-full md:w-1/4 text-center md:text-left mb-6 md:mb-0">
                    <h5 class="uppercase mb-6 font-bold text-gray-700">Categories</h5>
                    <ul class="mb-4">
                        @foreach ($categories->take(4) as $category)
                        <li class="mt-2">
                            <a href="{{ route('by-category', $category) }}" class="hover:underline text-gray-600 hover:text-blue-600 flex items-center md:inline-flex">
                                <i class="fas fa-tag mr-2"></i> {{ $category->name }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="w-full md:w-1/4 text-center md:text-left mb-6 md:mb-0">
                    <h5 class="uppercase mb-6 font-bold text-gray-700">Legal</h5>
                    <ul class="mb-4">
                        <li class="mt-2">
                            <a href="#" class="hover:underline text-gray-600 hover:text-blue-600 flex items-center md:inline-flex">
                                <i class="fas fa-gavel mr-2"></i> Terms of Use
                            </a>
                        </li>
                        <li class="mt-2">
                            <a href="#" class="hover:underline text-gray-600 hover:text-blue-600 flex items-center md:inline-flex">
                                <i class="fas fa-shield-alt mr-2"></i> Privacy Policy
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="w-full md:w-1/4 text-center md:text-left">
                    <h5 class="uppercase mb-6 font-bold text-gray-700">Connect With Us</h5>
                    <div class="flex justify-center md:justify-start space-x-4">
                        <a href="#" class="hover:text-blue-600 text-gray-600 text-xl">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="hover:text-blue-600 text-gray-600 text-xl">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="hover:text-blue-600 text-gray-600 text-xl">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="hover:text-blue-600 text-gray-600 text-xl">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="text-center pt-10 sm:pt-12 font-light flex items-center justify-center">
                <p class="text-gray-500">© {{ date('Y') }} kitablak blog. All rights reserved.</p>
            </div>
        </div>
    </footer>
    @livewireScripts

</body>

</html>