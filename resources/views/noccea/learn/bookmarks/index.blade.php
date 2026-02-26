@extends('noccea.learn.layout')

@section('title', 'My Bookmarks')

@section('content')
<div class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">My Bookmarks</h1>
            <p class="text-xl text-gray-600">Courses and resources you've saved for later</p>
        </div>

        @auth
        <!-- Bookmarked Items -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse(range(1, 3) as $i)
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition">
                <div class="aspect-video bg-gradient-to-br from-orange-400 to-orange-600"></div>
                <div class="p-6">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-lg font-bold text-gray-900 flex-1">Advanced {{ ['Web Development', 'Data Science', 'Mobile Apps'][$i-1] }}</h3>
                        <button class="ml-2 text-orange-600 hover:text-orange-700 transition" title="Remove bookmark">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M5 5a2 2 0 012-2h6a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                            </svg>
                        </button>
                    </div>
                    <div class="flex items-center gap-2 mb-3">
                        @for($j = 0; $j < 5; $j++)
                        <svg class="w-4 h-4 {{ $j < (3 + $i % 2) ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        @endfor
                        <span class="text-xs text-gray-500">{{ (3 + $i % 2) }}/5</span>
                    </div>
                    <p class="text-gray-600 text-sm mb-4">Learn the fundamentals with this comprehensive course from expert instructors.</p>
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-orange-600 font-semibold">$29.99</span>
                        <button class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 text-sm">Enroll Now</button>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-12">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h6a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">No Bookmarks Yet</h3>
                <p class="text-gray-600 mb-6">Start bookmarking courses to save them for later</p>
                <a href="{{ route('noccea.learn.courses.index') }}" class="inline-block px-6 py-3 bg-orange-600 text-white rounded-lg hover:bg-orange-700">
                    Browse Courses
                </a>
            </div>
            @endforelse
        </div>
        @else
        <div class="bg-orange-50 border border-orange-200 rounded-lg p-12 text-center">
            <svg class="w-16 h-16 mx-auto text-orange-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h6a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
            </svg>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Sign In to View Bookmarks</h3>
            <p class="text-gray-600 mb-6">You need to be signed in to save and view your bookmarks</p>
            <a href="{{ route('noccea.learn.login') }}" class="inline-block px-6 py-3 bg-orange-600 text-white rounded-lg hover:bg-orange-700">
                Sign In
            </a>
        </div>
        @endauth
    </div>
</div>
@endsection
