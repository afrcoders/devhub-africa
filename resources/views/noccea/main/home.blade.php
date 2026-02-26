@extends('noccea.main.layout')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
    <!-- Navigation (handled by layout) -->

    <!-- Hero Section -->
    <div class="pt-20 pb-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-5xl md:text-6xl font-bold text-gray-900 mb-6">
                Welcome to Noccea
            </h1>
            <p class="text-xl md:text-2xl text-gray-600 mb-8">
                The African Ecosystem for Innovation, Learning & Business
            </p>
            <p class="text-lg text-gray-500 mb-8 max-w-2xl mx-auto">
                Discover, learn, connect, and grow with our community of innovators,
                educators, and entrepreneurs across Africa.
            </p>

            <!-- Platform Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-12">
                <div class="bg-white rounded-lg p-4 shadow">
                    <div class="text-3xl font-bold text-blue-600">{{ $stats['total_courses'] }}</div>
                    <div class="text-sm text-gray-600">Courses</div>
                </div>
                <div class="bg-white rounded-lg p-4 shadow">
                    <div class="text-3xl font-bold text-green-600">{{ number_format($stats['total_users']) }}</div>
                    <div class="text-sm text-gray-600">Members</div>
                </div>
                <div class="bg-white rounded-lg p-4 shadow">
                    <div class="text-3xl font-bold text-purple-600">{{ $stats['total_discussions'] }}</div>
                    <div class="text-sm text-gray-600">Discussions</div>
                </div>
                <div class="bg-white rounded-lg p-4 shadow">
                    <div class="text-3xl font-bold text-orange-600">{{ $stats['total_businesses'] }}</div>
                    <div class="text-sm text-gray-600">Businesses</div>
                </div>
            </div>

            @auth
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('noccea.dashboard') }}" class="px-8 py-3 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 transition">
                        Go to Dashboard
                    </a>
                </div>
            @else
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('noccea.login') }}" class="px-8 py-3 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 transition">
                        Sign In
                    </a>
                </div>
            @endauth
        </div>
    </div>

    <!-- Featured Courses Section -->
    @if($featuredCourses->count() > 0)
    <div class="py-16 px-4 sm:px-6 lg:px-8 bg-gray-50">
        <div class="max-w-6xl mx-auto">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">
                        Popular Courses
                    </h2>
                    <p class="text-gray-600">Start learning with our most popular courses</p>
                </div>
                <a href="https://{{ config('domains.noccea.learn') }}" class="px-6 py-2 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 transition">
                    View All
                </a>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                @foreach($featuredCourses as $course)
                <a href="https://{{ config('domains.noccea.learn') }}/courses/{{ $course->slug }}" class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden group">
                    @if($course->image)
                        <img src="{{ $course->image_url }}" alt="{{ $course->title }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gradient-to-br {{ $course->image_color ?? 'from-blue-400 to-indigo-600' }} flex items-center justify-center">
                            <svg class="w-16 h-16 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                    @endif
                    <div class="p-6">
                        @if($course->category)
                        <span class="text-xs font-semibold text-indigo-600 bg-indigo-50 px-2 py-1 rounded">{{ $course->category }}</span>
                        @endif
                        <h3 class="text-lg font-semibold text-gray-900 mt-3 mb-2 group-hover:text-indigo-600 transition">
                            {{ $course->title }}
                        </h3>
                        <p class="text-gray-600 text-sm mb-4">{{ Str::limit($course->description, 80) }}</p>
                        <div class="flex items-center justify-between text-sm text-gray-500">
                            <span>{{ $course->students_count }} students</span>
                            <span>{{ $course->total_lessons }} lessons</span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Recent Discussions Section -->
    @if($recentDiscussions->count() > 0)
    <div class="py-16 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="max-w-6xl mx-auto">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">
                        Recent Discussions
                    </h2>
                    <p class="text-gray-600">Join the conversation in our community</p>
                </div>
                <a href="https://{{ config('domains.noccea.community') }}" class="px-6 py-2 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition">
                    View All
                </a>
            </div>

            <div class="space-y-4">
                @foreach($recentDiscussions as $discussion)
                <a href="https://{{ config('domains.noccea.community') }}/discussions/{{ $discussion->slug }}" class="block bg-gray-50 rounded-lg p-6 hover:bg-gray-100 transition">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $discussion->title }}</h3>
                            <div class="flex items-center gap-4 text-sm text-gray-600">
                                <span>{{ $discussion->user->first_name }} {{ $discussion->user->last_name }}</span>
                                <span>{{ $discussion->replies_count }} {{ Str::plural('reply', $discussion->replies_count) }}</span>
                                <span>{{ $discussion->last_activity_at->diffForHumans() }}</span>
                                @if($discussion->category)
                                <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs">{{ $discussion->category->name }}</span>
                                @endif
                            </div>
                        </div>
                        <span class="px-3 py-1 bg-green-100 text-green-700 text-sm font-semibold rounded">Active</span>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- CTA Section -->
    @guest
    <div class="py-16 px-4 sm:px-6 lg:px-8 bg-indigo-600">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                Ready to Join?
            </h2>
            <p class="text-lg text-indigo-100 mb-8">
                Become part of Africa's most vibrant innovation ecosystem today.
            </p>
            <a href="{{ route('noccea.login') }}" class="inline-block px-8 py-3 bg-white text-indigo-600 rounded-lg font-semibold hover:bg-indigo-50 transition">
                Sign In Now
            </a>
        </div>
    </div>
    @endguest
</div>
@endsection
