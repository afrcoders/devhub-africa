@extends('noccea.learn.layout')

@section('title', $course->title . ' - Learn Noccea')

@section('content')
<div class="bg-white">
    <!-- Hero Section -->
    <div class="relative h-96 bg-gradient-to-br {{ $course->image_color }} overflow-hidden">
        @if($course->image_url)
        <img src="{{ $course->image_url }}" alt="{{ $course->title }}" class="w-full h-full object-cover">
        @endif
        <div class="absolute inset-0 bg-black bg-opacity-40 flex items-end">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full pb-8">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <div class="flex gap-2 mb-4">
                            <span class="inline-block px-3 py-1 bg-white bg-opacity-90 text-xs font-semibold text-gray-900 rounded">
                                {{ $course->category }}
                            </span>
                            <span class="inline-block px-3 py-1 bg-white bg-opacity-90 text-xs font-semibold text-gray-900 rounded">
                                {{ $course->level }}
                            </span>
                        </div>
                        <h1 class="text-4xl font-bold text-white mb-2">{{ $course->title }}</h1>
                        <p class="text-white text-lg">by <span class="font-semibold">{{ $course->instructor }}</span></p>
                    </div>
                    <button class="p-3 bg-white rounded-full hover:bg-gray-100 transition" title="Bookmark course">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h6a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Left Column - Course Info -->
            <div class="lg:col-span-2">
                <!-- Overview -->
                <div class="mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Course Overview</h2>
                    <p class="text-lg text-gray-700 leading-relaxed">{{ $course->long_description }}</p>
                </div>

                <!-- Rating & Stats -->
                <div class="mb-12 pb-12 border-b border-gray-200">
                    <div class="grid grid-cols-3 gap-6">
                        <div class="flex items-center gap-3">
                            <div class="flex items-center">
                                @for($j = 0; $j < 5; $j++)
                                <svg class="w-5 h-5 {{ $j < floor($course->rating) ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                @endfor
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $course->rating }}</p>
                                <p class="text-sm text-gray-600">({{ $course->reviews }} reviews)</p>
                            </div>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">{{ number_format($course->students) }}</p>
                            <p class="text-sm text-gray-600">Students enrolled</p>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">{{ $course->duration }}</p>
                            <p class="text-sm text-gray-600">Course duration</p>
                        </div>
                    </div>
                </div>

                <!-- What You'll Learn -->
                <div class="mb-12 pb-12 border-b border-gray-200">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">What You'll Learn</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($course->topics ?? [] as $topic)
                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-green-500 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-gray-700">{{ $topic }}</span>
                        </div>
                        @empty
                        <div class="col-span-2 text-gray-500 text-center py-4">No topics listed yet</div>
                        @endforelse
                    </div>
                </div>

                <!-- Requirements -->
                <div class="mb-12">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Requirements</h2>
                    <ul class="space-y-3">
                        @forelse($course->requirements ?? [] as $requirement)
                        <li class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-blue-500 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-gray-700">{{ $requirement }}</span>
                        </li>
                        @empty
                        <li class="text-gray-500 text-center py-4">No requirements listed</li>
                        @endforelse
                    </ul>
                </div>

                <!-- Course Structure (Modules & Lessons) -->
                @php
                    $modules = $course->modules()->with('lessons')->orderBy('order')->get();
                @endphp
                @if($modules->count() > 0)
                <div class="mb-12">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Course Content</h2>
                    <div class="space-y-4">
                        @foreach($modules as $module)
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <button class="w-full px-6 py-4 bg-gray-50 hover:bg-gray-100 transition text-left flex items-center justify-between"
                                    onclick="this.nextElementSibling.classList.toggle('hidden')">
                                <div>
                                    <h3 class="font-semibold text-gray-900">{{ $module->title }}</h3>
                                    <p class="text-sm text-gray-600 mt-1">{{ $module->lessons->count() }} lessons</p>
                                </div>
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                </svg>
                            </button>
                            <div class="hidden divide-y divide-gray-200">
                                @foreach($module->lessons as $lesson)
                                <div class="px-6 py-4 hover:bg-gray-50 transition">
                                    <div class="flex items-start gap-3">
                                        <svg class="w-5 h-5 text-gray-400 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <div class="flex-1">
                                            <p class="font-medium text-gray-900">{{ $lesson->title }}</p>
                                            <p class="text-sm text-gray-600 mt-1">{{ $lesson->duration_minutes }} minutes</p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Reviews Section -->
                @php
                    $reviews = $course->reviews()->where('is_verified', true)->latest()->get();
                @endphp
                <div class="mb-12">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Student Reviews</h2>

                    @auth
                    <!-- Review Form -->
                    @php
                        $userReview = $course->reviews()->where('user_id', auth()->id())->first();
                    @endphp
                    <div class="mb-8 p-6 bg-gray-50 rounded-lg">
                        <h3 class="font-semibold text-gray-900 mb-4">
                            {{ $userReview ? 'Update Your Review' : 'Leave a Review' }}
                        </h3>
                        <form action="{{ route('noccea.learn.review.store', $course->id) }}" method="POST">
                            @csrf
                            @if($userReview)
                                @method('PUT')
                            @endif

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                                <div class="flex gap-2">
                                    @for($i = 1; $i <= 5; $i++)
                                    <input type="radio" name="rating" value="{{ $i }}" id="star{{ $i }}"
                                           {{ $userReview && $userReview->rating == $i ? 'checked' : '' }} class="hidden">
                                    <label for="star{{ $i }}" class="cursor-pointer">
                                        <svg class="w-8 h-8 text-gray-300 hover:text-yellow-400 transition" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    </label>
                                    @endfor
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">Your Review</label>
                                <textarea name="comment" id="comment" rows="4" placeholder="Share your experience with this course..."
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">{{ $userReview?->comment }}</textarea>
                            </div>

                            <button type="submit" class="px-6 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition font-medium">
                                {{ $userReview ? 'Update Review' : 'Submit Review' }}
                            </button>
                        </form>
                    </div>
                    @else
                    <div class="mb-8 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <p class="text-sm text-blue-900">
                            <a href="{{ route('noccea.learn.login') }}" class="font-semibold hover:underline">Sign in</a> to leave a review
                        </p>
                    </div>
                    @endauth

                    <!-- Reviews List -->
                    @if($reviews->count() > 0)
                    <div class="space-y-6">
                        @foreach($reviews as $review)
                        <div class="border-b border-gray-200 pb-6 last:border-b-0">
                            <div class="flex items-start justify-between mb-3">
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $review->user->name ?? 'Anonymous' }}</p>
                                    <div class="flex items-center gap-2 mt-1">
                                        <div class="flex">
                                            @for($j = 0; $j < 5; $j++)
                                            <svg class="w-4 h-4 {{ $j < $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                            @endfor
                                        </div>
                                        <span class="text-xs text-gray-600">{{ $review->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                                @if(auth()->check() && (auth()->id() === $review->user_id || auth()->user()->is_admin))
                                <div class="flex gap-2">
                                    <button onclick="editReview({{ $review->id }})" class="text-sm text-blue-600 hover:underline">Edit</button>
                                    <form action="{{ route('noccea.learn.review.destroy', $review) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Delete this review?')" class="text-sm text-red-600 hover:underline">Delete</button>
                                    </form>
                                </div>
                                @endif
                            </div>
                            <p class="text-gray-700">{{ $review->comment }}</p>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-center text-gray-600 py-8">No reviews yet. Be the first to review this course!</p>
                    @endif
                </div>
            </div>

            <!-- Right Sidebar -->
            <div class="lg:col-span-1">
                <!-- Enrollment Card -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-lg sticky top-20 p-6">
                    <div class="mb-6">
                        <p class="text-sm text-gray-600 mb-1">Price</p>
                        <p class="text-4xl font-bold text-green-600 mb-4">FREE</p>
                        @auth
                            @if($isEnrolled && $firstLessonUrl)
                                <a href="{{ $firstLessonUrl }}" class="block w-full px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold mb-3 text-center">
                                    <svg class="w-5 h-5 inline-block mr-2 -mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $hasProgress ? 'Continue Learning' : 'Start Course' }}
                                </a>
                            @elseif($isEnrolled)
                                <div class="block w-full px-6 py-3 bg-gray-300 text-gray-700 rounded-lg font-semibold mb-3 text-center cursor-not-allowed">
                                    <svg class="w-5 h-5 inline-block mr-2 -mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Enrolled
                                </div>
                            @else
                                <form action="{{ route('noccea.learn.enroll') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                                    <button type="submit" class="w-full px-6 py-3 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition font-semibold mb-3">
                                        Enroll Now
                                    </button>
                                </form>
                            @endif
                        @else
                            <a href="{{ route('noccea.learn.login') }}" class="block w-full px-6 py-3 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition font-semibold mb-3 text-center">
                                Sign In to Enroll
                            </a>
                        @endauth
                    </div>

                    <div class="space-y-4 pt-6 border-t border-gray-200">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{ $course->duration }}</p>
                                <p class="text-xs text-gray-600">Course duration</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.248 6.253 2 10.541 2 15.5s4.248 9.247 10 9.247m0-13c5.752 0 10-3.885 10-9.247"></path>
                            </svg>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{ $course->lessons }} lessons</p>
                                <p class="text-xs text-gray-600">Video content</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">Money-back guarantee</p>
                                <p class="text-xs text-gray-600">30 days</p>
                            </div>
                        </div>
                    </div>

                    <!-- Share Buttons -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <p class="text-sm font-semibold text-gray-900 mb-3">Share this course</p>
                        <div class="flex gap-2">
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('noccea.learn.courses.show', $course->slug)) }}&text=Check out {{ urlencode($course->title) }} on Noccea Learn" target="_blank" class="flex-1 px-3 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition text-center text-sm font-medium">
                                Twitter
                            </a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('noccea.learn.courses.show', $course->slug)) }}" target="_blank" class="flex-1 px-3 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition text-center text-sm font-medium">
                                Facebook
                            </a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(route('noccea.learn.courses.show', $course->slug)) }}" target="_blank" class="flex-1 px-3 py-2 bg-blue-700 text-white rounded hover:bg-blue-800 transition text-center text-sm font-medium">
                                LinkedIn
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Courses -->
        @if($relatedCourses && count($relatedCourses) > 0)
        <div class="mt-16 pt-16 border-t border-gray-200">
            <h2 class="text-3xl font-bold text-gray-900 mb-8">Related Courses</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($relatedCourses as $related)
                <div class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition">
                    <div class="aspect-video bg-gradient-to-br {{ $related->image_color }} overflow-hidden">
                        @if($related->image_url)
                        <img src="{{ $related->image_url }}" alt="{{ $related->title }}" class="w-full h-full object-cover">
                        @endif
                    </div>
                    <div class="p-6">
                        <div class="mb-2">
                            <span class="inline-block px-2 py-1 text-xs font-semibold text-orange-600 bg-orange-100 rounded">
                                {{ $related->category }}
                            </span>
                            <span class="inline-block ml-2 px-2 py-1 text-xs font-semibold text-gray-700 bg-gray-100 rounded">
                                {{ $related->level }}
                            </span>
                        </div>
                        <a href="{{ route('noccea.learn.courses.show', $related->slug) }}" class="text-lg font-bold text-gray-900 hover:text-orange-600 transition line-clamp-2">
                            {{ $related->title }}
                        </a>
                        <p class="text-sm text-gray-600 mt-2 mb-3">by <span class="font-semibold">{{ $related->instructor }}</span></p>

                        <div class="flex items-center gap-2 mb-4">
                            @for($j = 0; $j < 5; $j++)
                            <svg class="w-4 h-4 {{ $j < floor($related->rating) ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            @endfor
                            <span class="text-xs text-gray-600">{{ $related->rating }}</span>
                        </div>

                        <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-200">
                            <p class="text-2xl font-bold text-green-600">FREE</p>
                            <p class="text-sm text-gray-600">{{ $related->duration }}</p>
                        </div>

                        <a href="{{ route('noccea.learn.courses.show', $related->slug) }}" class="block w-full text-center px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition font-medium">
                            View Course
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
