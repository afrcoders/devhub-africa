@extends('noccea.learn.layout')

@section('content')
<div class="min-h-screen bg-gray-100">
    <!-- Dashboard Header -->
    <div class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <h1 class="text-3xl font-bold text-gray-900">
                Learning Dashboard
            </h1>
            <p class="text-gray-600 mt-2">
                Welcome, {{ Auth::user()->name ?? 'Learner' }}
            </p>
        </div>
    </div>

    <!-- Dashboard Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
            <!-- Stats -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.248 6.253 2 10.541 2 15.5s4.248 9.247 10 9.247m0-13c5.752 0 10-3.885 10-9.247"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Enrolled Courses</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['enrolled'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Completed</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['completed'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">In Progress</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['in_progress'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Discussion Posts</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['discussion_posts'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Active Enrollments -->
                <div class="bg-white rounded-lg shadow p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Your Active Courses</h2>

                    @if($enrolledCourses && count($enrolledCourses) > 0)
                        <div class="space-y-6">
                            @foreach($enrolledCourses as $enrollment)
                                <div class="border border-gray-200 rounded-lg p-6 hover:shadow-lg transition">
                                    <div class="flex items-start justify-between mb-4">
                                        <div class="flex-1">
                                            <a href="{{ route('noccea.learn.courses.show', $enrollment->course->slug) }}" class="text-xl font-bold text-gray-900 hover:text-orange-600 transition">
                                                {{ $enrollment->course->title }}
                                            </a>
                                            <p class="text-sm text-gray-600 mt-1">
                                                <span class="inline-block px-2 py-1 bg-orange-100 text-orange-800 rounded text-xs font-semibold mr-2">
                                                    {{ $enrollment->course->category }}
                                                </span>
                                                <span class="inline-block px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs font-semibold">
                                                    {{ $enrollment->course->level }}
                                                </span>
                                            </p>
                                        </div>
                                        <div class="text-right ml-4">
                                            <p class="text-2xl font-bold text-orange-600">{{ $enrollment->progress_percentage }}%</p>
                                            <p class="text-xs text-gray-500">Complete</p>
                                        </div>
                                    </div>

                                    <!-- Progress Bar -->
                                    <div class="mb-4">
                                        <div class="w-full bg-gray-200 rounded-full h-3">
                                            <div class="bg-orange-600 h-3 rounded-full transition-all duration-300"
                                                 style="width: {{ $enrollment->progress_percentage }}%"></div>
                                        </div>
                                        <p class="text-xs text-gray-600 mt-2">
                                            {{ $enrollment->completed_lessons }} of {{ $enrollment->total_lessons }} lessons completed
                                        </p>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="flex gap-3">
                                        @if($enrollment->progress_percentage > 0)
                                            <a href="{{ route('noccea.learn.courses.show', $enrollment->course->slug) }}"
                                               class="flex-1 text-center px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition font-medium">
                                                Continue Learning →
                                            </a>
                                        @else
                                            <a href="{{ route('noccea.learn.courses.show', $enrollment->course->slug) }}"
                                               class="flex-1 text-center px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition font-medium">
                                                Start Course →
                                            </a>
                                        @endif
                                        <a href="{{ route('noccea.learn.courses.show', $enrollment->course->slug) }}"
                                           class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12 text-gray-500">
                            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <p class="mb-4 text-lg">You're not currently enrolled in any courses.</p>
                            <p class="mb-6 text-sm">Start your learning journey today!</p>
                            <a href="{{ route('noccea.learn.courses.index') }}" class="inline-block px-6 py-3 bg-orange-600 text-white rounded-lg hover:bg-orange-700 font-medium transition">
                                Browse Courses →
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Course Catalog -->
                <div class="bg-white rounded-lg shadow p-8">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Featured Courses</h2>
                        <a href="{{ route('noccea.learn.courses.index') }}" class="text-orange-600 hover:text-orange-700 font-medium text-sm">
                            View all →
                        </a>
                    </div>

                    @if($featuredCourses && count($featuredCourses) > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach(collect($featuredCourses)->take(4) as $course)
                                <a href="{{ route('noccea.learn.courses.show', $course->slug) }}" class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow block">
                                    <!-- Course Image Placeholder -->
                                    <div class="h-40 bg-gradient-to-br {{ $course->image_color }} relative overflow-hidden">
                                        @if($course->image_url)
                                        <img src="{{ $course->image_url }}" alt="{{ $course->title }}" class="w-full h-full object-cover">
                                        @endif
                                        <div class="absolute top-3 right-3">
                                            <button @click.prevent class="p-2 bg-white rounded-full hover:bg-gray-100 transition" title="Bookmark course">
                                                <svg class="w-5 h-5 text-gray-400 hover:text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h6a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="absolute bottom-3 left-3">
                                            <span class="inline-block px-3 py-1 bg-white bg-opacity-90 text-xs font-semibold text-gray-900 rounded">
                                                {{ $course->level }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Course Info -->
                                    <div class="p-5">
                                        <div class="flex items-start justify-between mb-2">
                                            <p class="text-xs font-medium text-orange-600 uppercase tracking-wide">{{ $course->category }}</p>
                                            <p class="text-xs font-semibold text-gray-500">{{ $course->duration }}</p>
                                        </div>

                                        <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2">{{ $course->title }}</h3>

                                        <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $course->description }}</p>

                                        <!-- Rating -->
                                        <div class="flex items-center gap-2 mb-4">
                                            <div class="flex items-center">
                                                @for($i = 0; $i < 5; $i++)
                                                    <svg class="w-4 h-4 {{ $i < floor($course->rating) ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                    </svg>
                                                @endfor
                                            </div>
                                            <span class="text-xs text-gray-600">{{ $course->rating }} ({{ $course->reviews }})</span>
                                        </div>

                                        <!-- Price and Students -->
                                        <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-200">
                                            <div>
                                                <p class="text-2xl font-bold text-green-600">FREE</p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-xs text-gray-600">{{ number_format($course->students) }} enrolled</p>
                                            </div>
                                        </div>

                                        <!-- Enroll Button -->
                                        <button class="w-full px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition font-medium">
                                            Enroll Now
                                        </button>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12 text-gray-500">
                            <p class="mb-4">No featured courses available at the moment.</p>
                            <a href="{{ route('noccea.learn.courses') }}" class="text-orange-600 hover:text-orange-700 font-medium">
                                Browse all courses →
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right Sidebar -->
            <div class="space-y-6">
                <!-- Quick Links -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Links</h3>
                    <div class="space-y-3">
                        <a href="{{ route('noccea.learn.courses.index') }}" class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition">
                            <span class="text-gray-700">Browse All Courses</span>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                        <a href="{{ route('noccea.learn.certificates.index') }}" class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition">
                            <span class="text-gray-700">View Certificates</span>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                        <a href="{{ route('noccea.learn.qa-forum.index') }}" class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition">
                            <span class="text-gray-700">Discussion Q&A</span>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                        <a href="{{ route('noccea.learn.dashboard') }}" class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition">
                            <span class="text-gray-700">My Learning Path</span>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Learner Profile -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Your Profile</h3>
                    <div class="text-center mb-4">
                        <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <p class="font-semibold text-gray-900">{{ Auth::user()->name ?? 'Learner' }}</p>
                        <p class="text-sm text-gray-600">{{ Auth::user()->email ?? 'learner@example.com' }}</p>
                    </div>
                    <a href="#" class="block w-full text-center px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition">
                        Edit Profile
                    </a>
                </div>

                <!-- Quick Links -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Links</h3>
                    <div class="space-y-3">
                        <a href="#" class="block text-orange-600 hover:text-orange-700 font-medium">Browse All Courses →</a>
                        <a href="#" class="block text-orange-600 hover:text-orange-700 font-medium">View Certificates →</a>
                        <a href="#" class="block text-orange-600 hover:text-orange-700 font-medium">Discussion Q&A →</a>
                        <a href="#" class="block text-orange-600 hover:text-orange-700 font-medium">My Learning Path →</a>
                    </div>
                </div>

                <!-- Learning Streak -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Learning Streak</h3>
                    <div class="text-center">
                        <p class="text-4xl font-bold text-orange-600 mb-2">0</p>
                        <p class="text-gray-600">days in a row</p>
                        <p class="text-sm text-gray-500 mt-4">Keep learning to build your streak!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
