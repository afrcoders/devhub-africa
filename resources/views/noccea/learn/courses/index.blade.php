@extends('noccea.learn.layout')

@section('title', 'Browse Courses')

@section('content')
<div class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Courses</h1>
            <p class="text-xl text-gray-600">Discover and explore courses from top instructors</p>
        </div>

        <!-- Search and Filter -->
        <div class="mb-8 grid grid-cols-1 md:grid-cols-3 gap-4">
            <input type="text" placeholder="Search courses..." class="px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
            <select id="categoryFilter" class="px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500" onchange="filterCourses()">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                <option value="{{ $category }}" {{ $selectedCategory === $category ? 'selected' : '' }}>
                    {{ $category }}
                </option>
                @endforeach
            </select>
            <select id="levelFilter" class="px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500" onchange="filterCourses()">
                <option value="">All Levels</option>
                @foreach($levels as $level)
                <option value="{{ $level }}" {{ $selectedLevel === $level ? 'selected' : '' }}>
                    {{ $level }}
                </option>
                @endforeach
            </select>
        </div>

        <script>
        function filterCourses() {
            const category = document.getElementById('categoryFilter').value;
            const level = document.getElementById('levelFilter').value;
            const params = new URLSearchParams();

            if (category) params.set('category', category);
            if (level) params.set('level', level);

            const url = '{{ route('noccea.learn.courses.index') }}' + (params.toString() ? '?' + params.toString() : '');
            window.location.href = url;
        }
        </script>

        <!-- Courses Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($courses as $course)
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition">
                <div class="aspect-video bg-gradient-to-br {{ $course->image_color }} overflow-hidden">
                    @if($course->image_url)
                    <img src="{{ $course->image_url }}" alt="{{ $course->title }}" class="w-full h-full object-cover">
                    @else
                    <div class="w-full h-full bg-gradient-to-br {{ $course->image_color }}"></div>
                    @endif
                </div>
                <div class="p-6">
                    <div class="mb-2">
                        <span class="inline-block px-2 py-1 text-xs font-semibold text-orange-600 bg-orange-100 rounded">
                            {{ $course->category }}
                        </span>
                        <span class="inline-block ml-2 px-2 py-1 text-xs font-semibold text-gray-700 bg-gray-100 rounded">
                            {{ $course->level }}
                        </span>
                    </div>
                    <div class="flex justify-between items-start mb-2">
                        <a href="{{ route('noccea.learn.courses.show', $course->slug) }}" class="text-lg font-bold text-gray-900 flex-1 hover:text-orange-600 transition">{{ $course->title }}</a>
                        <button class="ml-2 text-gray-400 hover:text-orange-600 transition" title="Bookmark course">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h6a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                            </svg>
                        </button>
                    </div>
                    <p class="text-sm text-gray-600 mb-2">by <span class="font-semibold">{{ $course->instructor }}</span></p>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $course->description }}</p>
                    <div class="flex items-center gap-2 mb-4">
                        @for($j = 0; $j < 5; $j++)
                        <svg class="w-4 h-4 {{ $j < floor($course->rating) ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        @endfor
                        <span class="text-xs text-gray-600">{{ $course->rating }} ({{ $course->reviews }})</span>
                    </div>
                    <div class="flex items-center justify-between gap-2 mb-4 pb-4 border-b border-gray-200">
                        <div>
                            <p class="text-sm text-gray-600">{{ $course->duration }}</p>
                            <p class="text-2xl font-bold text-green-600">FREE</p>
                        </div>
                        <div class="text-right text-sm">
                            <p class="text-gray-600">{{ number_format($course->students) }} enrolled</p>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('noccea.learn.courses.show', $course->slug) }}" class="flex-1 text-center px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition font-medium">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-12">
                <p class="text-gray-500">No courses available yet</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
