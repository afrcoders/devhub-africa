<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noccea Business - @yield('title', 'Business Discovery & Networking')</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/noccea/favicon.ico">
    <link rel="icon" type="image/png" sizes="16x16" href="/noccea/favicon-16x16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/noccea/favicon-32x32.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/noccea/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/noccea/android-chrome-192x192.png">
    <link rel="icon" type="image/png" sizes="512x512" href="/noccea/android-chrome-512x512.png">

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('head')
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo/Brand -->
                <div class="flex items-center">
                    <a href="{{ route('noccea.business.home') }}" class="flex items-center">
                        <img src="/noccea/logo.svg" alt="Noccea Business" class="h-8">
                    </a>
                </div>

                <!-- Center Navigation -->
                <div class="hidden md:flex space-x-8">
                    <a href="{{ route('noccea.business.home') }}" class="text-gray-600 hover:text-gray-900 font-medium">Home</a>
                    <a href="{{ route('noccea.business.businesses.index') }}" class="text-gray-600 hover:text-gray-900 font-medium">Browse</a>
                    <a href="{{ route('noccea.business.categories.index') }}" class="text-gray-600 hover:text-gray-900 font-medium">Categories</a>
                    @auth
                        <a href="{{ route('noccea.business.bookmarks.index') }}" class="text-gray-600 hover:text-gray-900 font-medium">
                            <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h6a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                            </svg>
                            Bookmarks
                        </a>
                        <a href="{{ route('noccea.business.businesses.create') }}" class="text-gray-600 hover:text-gray-900 font-medium">Create Listing</a>
                        <a href="{{ route('noccea.business.dashboard') }}" class="text-gray-600 hover:text-gray-900 font-medium">My Listings</a>
                    @endauth
                </div>

                <!-- Right side - Auth -->
                <div class="flex items-center space-x-4">
                    @auth
                        <span class="text-gray-700">{{ Auth::user()->name ?? 'Business' }}</span>
                        <a href="{{ route('noccea.business.dashboard') }}" class="text-purple-600 hover:text-purple-700 font-medium">
                            Dashboard
                        </a>
                        <form action="{{ route('noccea.business.logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-600 hover:text-gray-900 font-medium">
                                Sign Out
                            </button>
                        </form>
                    @else
                        <a href="{{ route('noccea.business.login') }}" class="text-purple-600 hover:text-purple-700 font-medium">
                            Sign In
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    @yield('content')

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h3 class="text-white font-bold mb-4">Noccea Business</h3>
                    <p class="text-sm">Business Discovery & Networking Platform</p>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-4">Businesses</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('noccea.business.businesses.index') }}" class="hover:text-white">Browse Listings</a></li>
                        <li><a href="{{ route('noccea.business.businesses.create') }}" class="hover:text-white">Create Listing</a></li>
                        <li><a href="{{ route('noccea.business.businesses.featured') }}" class="hover:text-white">Top Businesses</a></li>
                        <li><a href="{{ route('noccea.business.categories.index') }}" class="hover:text-white">Categories</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-4">Support</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="https://{{ config('domains.africoders.help') }}/" class="hover:text-white">Help Center</a></li>
                        <li><a href="https://{{ config('domains.africoders.help') }}/contact" class="hover:text-white">Contact Us</a></li>
                        <li><a href="https://{{ config('domains.africoders.help') }}/business-guidelines" class="hover:text-white">Best Practices</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-4">Legal</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="https://{{ config('domains.africoders.help') }}/privacy" class="hover:text-white">Privacy</a></li>
                        <li><a href="https://{{ config('domains.africoders.help') }}/terms" class="hover:text-white">Terms</a></li>
                        <li><a href="https://{{ config('domains.africoders.help') }}/business-policies" class="hover:text-white">Policies</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-sm">
                <p>&copy; {{ date('Y') }} Noccea Business. All rights reserved.</p>
            </div>
        </div>
    </footer>

    @if(session('success'))
    <div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg">
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg max-w-sm">
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
    @endif
</body>
</html>
