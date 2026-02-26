<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noccea - @yield('title', 'The African Innovation Ecosystem')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo/Brand -->
                <div class="flex items-center">
                    <a href="{{ route('noccea.home') }}" class="text-2xl font-bold text-indigo-600">
                        Noccea
                    </a>
                </div>

                <!-- Center Navigation - Ecosystem Links -->
                <div class="hidden md:flex space-x-6">
                    <a href="https://{{ config('domains.noccea.learn') }}" class="text-gray-600 hover:text-indigo-600 font-medium transition flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        Learn
                    </a>
                    <a href="https://{{ config('domains.noccea.community') }}" class="text-gray-600 hover:text-green-600 font-medium transition flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path>
                        </svg>
                        Community
                    </a>
                    <a href="https://{{ config('domains.noccea.business') }}" class="text-gray-600 hover:text-purple-600 font-medium transition flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        Business
                    </a>
                    <a href="https://{{ config('domains.africoders.main') }}" class="text-gray-600 hover:text-orange-600 font-medium transition flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Africoders
                    </a>
                </div>

                <!-- Right side - Auth -->
                <div class="flex items-center space-x-4">
                    @auth
                        <span class="text-gray-700">{{ Auth::user()->name ?? 'User' }}</span>
                        <a href="{{ route('noccea.dashboard') }}" class="text-indigo-600 hover:text-indigo-700 font-medium">
                            Dashboard
                        </a>
                        <form action="{{ route('noccea.logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-600 hover:text-gray-900 font-medium">
                                Sign Out
                            </button>
                        </form>
                    @else
                        <a href="{{ route('noccea.login') }}" class="text-indigo-600 hover:text-indigo-700 font-medium">
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
                    <h3 class="text-white font-bold mb-4">Noccea</h3>
                    <p class="text-sm">The African Ecosystem for Innovation, Learning & Business</p>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-4">Platforms</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="https://{{ config('domains.noccea.learn') }}" class="hover:text-white">Noccea Learn</a></li>
                        <li><a href="https://{{ config('domains.noccea.community') }}" class="hover:text-white">Noccea Community</a></li>
                        <li><a href="https://{{ config('domains.noccea.business') }}" class="hover:text-white">Noccea Business</a></li>
                        <li><a href="https://{{ config('domains.africoders.main') }}" class="hover:text-white">Africoders</a></li>
                        <li><a href="https://{{ config('domains.africoders.kortex') }}" class="hover:text-white">Kortex Tools</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-4">Support</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="https://{{ config('domains.africoders.help') }}" class="hover:text-white">Help Center</a></li>
                        <li><a href="https://{{ config('domains.africoders.help') }}/contact" class="hover:text-white">Contact Us</a></li>
                        <li><a href="https://{{ config('domains.africoders.help') }}/faq" class="hover:text-white">FAQ</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-4">Legal</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white">Privacy</a></li>
                        <li><a href="#" class="hover:text-white">Terms</a></li>
                        <li><a href="#" class="hover:text-white">Code of Conduct</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-sm">
                <p>&copy; {{ date('Y') }} Noccea. All rights reserved.</p>
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
