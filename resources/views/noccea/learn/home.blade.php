@extends('noccea.learn.layout')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-amber-50 to-orange-100">
    <!-- Hero Section -->
    <div class="pt-20 pb-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <h1 class="text-5xl md:text-6xl font-bold text-gray-900 mb-6">
                        Master New Skills with Expert-Led Courses
                    </h1>
                    <p class="text-xl text-gray-600 mb-8">
                        Join {{ number_format($stats['total_students']) }}+ learners building their careers with {{ $stats['total_courses'] }} industry-relevant courses
                    </p>

                    @auth
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="{{ route('noccea.learn.courses.index') }}" class="px-8 py-4 bg-orange-600 text-white rounded-lg font-semibold hover:bg-orange-700 transition text-center">
                                Explore Courses
                            </a>
                            <a href="{{ route('noccea.learn.dashboard') }}" class="px-8 py-4 bg-white text-orange-600 rounded-lg font-semibold border-2 border-orange-600 hover:bg-orange-50 transition text-center">
                                My Dashboard
                            </a>
                        </div>
                    @else
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="{{ route('noccea.learn.login') }}" class="px-8 py-4 bg-orange-600 text-white rounded-lg font-semibold hover:bg-orange-700 transition text-center">
                                Get Started Free
                            </a>
                            <a href="{{ route('noccea.learn.courses.index') }}" class="px-8 py-4 bg-white text-orange-600 rounded-lg font-semibold border-2 border-orange-600 hover:bg-orange-50 transition text-center">
                                Browse Courses
                            </a>
                        </div>
                    @endauth
                </div>

                <div class="relative">
                    <div class="bg-white rounded-2xl shadow-2xl p-8">
                        <div class="grid grid-cols-2 gap-6">
                            <div class="text-center p-4 bg-orange-50 rounded-lg">
                                <p class="text-3xl font-bold text-orange-600">{{ $stats['total_courses'] }}</p>
                                <p class="text-sm text-gray-600 mt-1">Courses</p>
                            </div>
                            <div class="text-center p-4 bg-blue-50 rounded-lg">
                                <p class="text-3xl font-bold text-blue-600">{{ number_format($stats['total_students']) }}+</p>
                                <p class="text-sm text-gray-600 mt-1">Students</p>
                            </div>
                            <div class="text-center p-4 bg-green-50 rounded-lg">
                                <p class="text-3xl font-bold text-green-600">{{ $stats['total_lessons'] }}</p>
                                <p class="text-sm text-gray-600 mt-1">Lessons</p>
                            </div>
                            <div class="text-center p-4 bg-purple-50 rounded-lg">
                                <p class="text-3xl font-bold text-purple-600">{{ number_format($stats['total_completions']) }}</p>
                                <p class="text-sm text-gray-600 mt-1">Completions</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories Section -->
    <div class="py-16 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Explore by Category
            </h2>
            <p class="text-gray-600 mb-12">Find courses that match your interests and career goals</p>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach($categories as $category)
                <a href="{{ route('noccea.learn.courses.index', ['category' => $category->category]) }}" class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-lg p-6 hover:shadow-lg transition text-center group">
                    <div class="w-12 h-12 bg-orange-600 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-1">{{ $category->category }}</h3>
                    <p class="text-sm text-gray-600">{{ $category->count }} courses</p>
                </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Featured Courses Section -->
    <div class="py-16 px-4 sm:px-6 lg:px-8 bg-gray-50">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between items-center mb-12">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        Featured Courses
                    </h2>
                    <p class="text-gray-600">Start learning today with our most popular courses</p>
                </div>
                <a href="{{ route('noccea.learn.courses.index') }}" class="hidden md:inline-block px-6 py-3 bg-orange-600 text-white rounded-lg font-semibold hover:bg-orange-700 transition">
                    View All Courses →
                </a>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($featuredCourses as $course)
                <a href="{{ route('noccea.learn.courses.show', $course->slug) }}" class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition group">
                    <div class="h-48 bg-gradient-to-br {{ $course->image_color ?? 'from-orange-400 to-orange-600' }} relative overflow-hidden">
                        @if($course->image)
                        <img src="{{ $course->image_url }}" alt="{{ $course->title }}" class="w-full h-full object-cover">
                        @endif
                        <div class="absolute inset-0 bg-black bg-opacity-20 group-hover:bg-opacity-10 transition"></div>
                        <div class="absolute bottom-4 left-4">
                            <span class="inline-block px-3 py-1 bg-white bg-opacity-90 text-xs font-semibold text-gray-900 rounded">
                                {{ $course->level }}
                            </span>
                        </div>
                        <div class="absolute top-4 right-4">
                            <span class="inline-block px-3 py-1 bg-orange-600 text-white text-xs font-semibold rounded">
                                {{ $course->total_lessons }} Lessons
                            </span>
                        </div>
                    </div>

                    <div class="p-6">
                        <p class="text-xs font-medium text-orange-600 uppercase tracking-wide mb-2">{{ $course->category }}</p>
                        <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-orange-600 transition">{{ $course->title }}</h3>
                        <p class="text-gray-600 mb-4 line-clamp-2 text-sm">{{ $course->description }}</p>

                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 12H9m4 5h-4m2-12a9 9 0 110 18 9 9 0 010-18z"></path>
                                </svg>
                                {{ number_format($course->students_count) }} enrolled
                            </div>
                            <span class="text-2xl font-bold text-green-600">FREE</span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

            <div class="text-center mt-12 md:hidden">
                <a href="{{ route('noccea.learn.courses.index') }}" class="inline-block px-8 py-3 bg-orange-600 text-white rounded-lg font-semibold hover:bg-orange-700 transition">
                    View All Courses →
                </a>
            </div>
        </div>
    </div>

    <!-- Q&A Forum Section -->
    <div class="py-16 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between items-center mb-12">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        Community Q&A
                    </h2>
                    <p class="text-gray-600">Get help from our active learning community</p>
                </div>
                <a href="{{ route('noccea.learn.qa-forum.index') }}" class="hidden md:inline-block px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                    View All Questions →
                </a>
            </div>

            @if($recentQuestions->count() > 0)
            <div class="space-y-4">
                @foreach($recentQuestions as $question)
                <a href="{{ route('noccea.learn.qa-forum.show', $question->slug) }}" class="block bg-gray-50 rounded-lg p-6 hover:bg-gray-100 transition">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2 hover:text-orange-600 transition">{{ $question->title }}</h3>
                            <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ Str::limit(strip_tags($question->body), 150) }}</p>
                            <div class="flex items-center gap-4 text-sm text-gray-500">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    {{ $question->user->name }}
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                                    </svg>
                                    {{ $question->answers_count }} answers
                                </span>
                                <span>{{ $question->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        @if($question->is_solved)
                        <div class="flex-shrink-0">
                            <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Solved
                            </span>
                        </div>
                        @endif
                    </div>
                </a>
                @endforeach
            </div>

            <div class="text-center mt-8">
                <a href="{{ route('noccea.learn.qa-forum.index') }}" class="inline-block px-8 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                    View All Questions →
                </a>
            </div>
            @else
            <div class="text-center py-12 bg-gray-50 rounded-lg">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                </svg>
                <p class="text-gray-500 mb-4">No questions yet. Be the first to ask!</p>
                <a href="{{ route('noccea.learn.qa-forum.create') }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                    Ask a Question
                </a>
            </div>
            @endif
        </div>
    </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-16 px-4 sm:px-6 lg:px-8 bg-gradient-to-br from-orange-600 to-orange-700">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl md:text-4xl font-bold text-center text-white mb-12">
                Why Choose Noccea Learn?
            </h2>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-xl p-8 text-white">
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3">Structured Learning</h3>
                    <p class="text-orange-100">
                        Follow carefully designed curricula with slide-based lessons, hands-on exercises, and real-world projects
                    </p>
                </div>

                <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-xl p-8 text-white">
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3">Active Community</h3>
                    <p class="text-orange-100">
                        Connect with fellow learners, ask questions in our Q&A forum, and get support when you need it
                    </p>
                </div>

                <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-xl p-8 text-white">
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3">Track Progress</h3>
                    <p class="text-orange-100">
                        Monitor your learning journey with detailed progress tracking and celebrate your achievements
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    @guest
    <div class="py-16 px-4 sm:px-6 lg:px-8 bg-gray-900">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                Ready to Start Learning?
            </h2>
            <p class="text-lg text-gray-300 mb-8">
                Join {{ number_format($stats['total_students']) }}+ students already learning on Noccea Learn
            </p>
            <a href="{{ route('noccea.learn.login') }}" class="inline-block px-8 py-4 bg-orange-600 text-white rounded-lg font-semibold hover:bg-orange-700 transition text-lg">
                Get Started Free →
            </a>
        </div>
    </div>
    @endguest
</div>
@endsection
