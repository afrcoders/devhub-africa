@extends('noccea.business.layout')

@section('title', $business->name)

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Back Navigation -->
        <div class="mb-6">
            <a href="{{ route('noccea.business.businesses.index') }}"
               class="inline-flex items-center text-purple-600 hover:text-purple-700 font-medium">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Businesses
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Business Header -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $business->name }}</h1>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                                {{ $business->category->name }}
                            </span>
                        </div>

                        <div class="flex items-center space-x-3">
                            @auth
                                @if(auth()->user()->bookmarkedBusinesses()->where('business_id', $business->id)->exists())
                                    <!-- Remove bookmark -->
                                    <form action="{{ route('noccea.business.businesses.unbookmark', $business) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-3 py-2 border border-red-300 rounded-lg text-sm font-medium text-red-600 bg-red-50 hover:bg-red-100 hover:border-red-400 transition-colors">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/>
                                            </svg>
                                            Remove Bookmark
                                        </button>
                                    </form>
                                @else
                                    <!-- Add bookmark -->
                                    <form action="{{ route('noccea.business.businesses.bookmark', $business) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-400 transition-colors">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 20 20">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                            </svg>
                                            Bookmark
                                        </button>
                                    </form>
                                @endif
                            @endauth

                            {{-- Social Share Button --}}
                            <div class="relative">
                                @include('shared.social-share', [
                                    'url' => request()->url(),
                                    'title' => $business->name . ' - ' . $business->category->name,
                                    'type' => 'business',
                                    'position' => 'top-full right-0'
                                ])
                            </div>

                            @if($business->featured)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    Featured
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center space-x-4 text-sm text-gray-600 mb-6">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            {{ $business->city }}, {{ $business->country }}
                        </div>

                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            {{ number_format($business->views_count) }} views
                        </div>

                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a4 4 0 118 0v4m-4 8a4 4 0 01-4-4V8a4 4 0 114 4 4 0 01-4 4z"></path>
                            </svg>
                            By {{ $business->user->username ?? 'Business Owner' }}
                        </div>

                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a4 4 0 118 0v4m-4 8a4 4 0 01-4-4V8a4 4 0 114 4 4 0 01-4 4z"></path>
                            </svg>
                            {{ $business->created_at->format('M d, Y') }}
                        </div>
                    </div>

                    <!-- Rating -->
                    <div class="flex items-center mb-6">
                        @if($business->rating > 0)
                            <div class="flex items-center">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-5 h-5 {{ $i <= $business->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                @endfor
                                <span class="text-lg font-semibold text-gray-900 ml-2">{{ $business->rating }}</span>
                                <span class="text-gray-600 ml-1">({{ $business->reviews_count }} reviews)</span>
                            </div>
                        @else
                            <span class="text-gray-500">No ratings yet</span>
                        @endif
                    </div>

                    <!-- Description -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">About</h3>
                        <p class="text-gray-600 leading-relaxed">{{ $business->description }}</p>
                    </div>
                </div>

                <!-- Additional Information -->
                @if($business->address)
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Location</h3>
                        <p class="text-gray-600">{{ $business->address }}</p>
                    </div>
                @endif

                <!-- Reviews Section -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Reviews & Ratings</h3>

                    @auth
                        @if($business->canBeReviewedBy(auth()->user()))
                            <!-- Add Review Form -->
                            <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                                <h4 class="font-medium text-gray-900 mb-3">Write a Review</h4>
                                <form action="{{ route('noccea.business.businesses.reviews.store', $business) }}" method="POST">
                                    @csrf

                                    <!-- Rating Input -->
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                                        <div class="flex items-center space-x-1">
                                            @for($i = 1; $i <= 5; $i++)
                                                <label class="cursor-pointer">
                                                    <input type="radio" name="rating" value="{{ $i }}" class="sr-only peer" required>
                                                    <svg class="w-6 h-6 text-gray-300 peer-checked:text-yellow-400 hover:text-yellow-400 transition-colors"
                                                         fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                    </svg>
                                                </label>
                                            @endfor
                                        </div>
                                        @error('rating')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Comment Input -->
                                    <div class="mb-4">
                                        <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">Comment (optional)</label>
                                        <textarea name="comment" id="comment" rows="3"
                                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                                                  placeholder="Share your experience with this business..."></textarea>
                                        @error('comment')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <button type="submit"
                                            class="px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition-colors">
                                        Submit Review
                                    </button>
                                </form>
                            </div>
                        @elseif(auth()->id() === $business->user_id)
                            <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                                <p class="text-sm text-blue-700">You cannot review your own business.</p>
                            </div>
                        @elseif($business->reviews()->where('user_id', auth()->id())->exists())
                            <div class="mb-6 p-4 bg-green-50 rounded-lg">
                                <p class="text-sm text-green-700">Thank you for your review!</p>
                            </div>
                        @endif
                    @else
                        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-700">
                                <a href="{{ route('noccea.business.login') }}" class="text-purple-600 hover:text-purple-700 font-medium">Sign in</a>
                                to write a review
                            </p>
                        </div>
                    @endauth

                    <!-- Existing Reviews -->
                    @if($business->reviews->count() > 0)
                        <div class="space-y-4">
                            @foreach($business->reviews()->with('user')->approved()->latest()->limit(10)->get() as $review)
                                <div class="border-b border-gray-200 pb-4 last:border-b-0 last:pb-0">
                                    <div class="flex items-start justify-between mb-2">
                                        <div class="flex items-center">
                                            <div class="flex items-center mr-3">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                                         fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                    </svg>
                                                @endfor
                                            </div>
                                            <span class="font-medium text-gray-900">{{ $review->user->username ?? $review->user->name }}</span>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <span class="text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                                            @auth
                                                @if(auth()->user()->id === $review->user_id || auth()->user()->is_admin)
                                                    <!-- Edit Button -->
                                                    <button type="button"
                                                            onclick="editReview({{ $review->id }}, {{ $review->rating }}, `{{ addslashes($review->comment) }}`)"
                                                            class="text-blue-600 hover:text-blue-700 text-sm font-medium px-2 py-1">
                                                        Edit
                                                    </button>
                                                    <!-- Delete Button -->
                                                    <form action="{{ route('noccea.business.reviews.delete', $review) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this review?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-700 text-sm font-medium px-2 py-1">
                                                            Delete
                                                        </button>
                                                    </form>
                                                @endif
                                            @endauth
                                        </div>
                                    </div>
                                    @if($review->comment)
                                        <p class="text-gray-700 text-sm">{{ $review->comment }}</p>
                                    @endif
                                </div>
                            @endforeach

                            @if($business->reviews()->approved()->count() > 10)
                                <div class="text-center pt-4">
                                    <button class="text-purple-600 hover:text-purple-700 text-sm font-medium">
                                        View All Reviews ({{ $business->reviews()->approved()->count() }})
                                    </button>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="text-center py-6">
                            <p class="text-gray-500">No reviews yet. Be the first to review this business!</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Contact Information -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Contact Information</h3>
                    <div class="space-y-3">
                        @if($business->website)
                            <a href="{{ $business->website }}" target="_blank"
                               class="flex items-center text-purple-600 hover:text-purple-700">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                                Website
                            </a>
                        @endif

                        @if($business->email)
                            <a href="mailto:{{ $business->email }}"
                               class="flex items-center text-purple-600 hover:text-purple-700">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                {{ $business->email }}
                            </a>
                        @endif

                        @if($business->phone)
                            <a href="tel:{{ $business->phone }}"
                               class="flex items-center text-purple-600 hover:text-purple-700">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                {{ $business->phone }}
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Related Businesses -->
                @if(isset($relatedBusinesses) && $relatedBusinesses->count() > 0)
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Related Businesses</h3>
                        <div class="space-y-3">
                            @foreach($relatedBusinesses as $related)
                                <div class="border-b border-gray-200 pb-3 last:border-b-0 last:pb-0">
                                    <h4 class="font-medium text-gray-900 hover:text-purple-600">
                                        <a href="{{ route('noccea.business.businesses.show', $related) }}">{{ $related->name }}</a>
                                    </h4>
                                    <p class="text-sm text-gray-600">{{ $related->city }}, {{ $related->country }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Actions -->
                @auth
                    @if(auth()->id() === $business->user_id)
                        <div class="bg-white rounded-lg shadow p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Manage Listing</h3>
                            <div class="space-y-3">
                                <button class="w-full text-left px-4 py-2 text-purple-600 hover:bg-purple-50 rounded-lg">
                                    Edit Business
                                </button>
                                <button class="w-full text-left px-4 py-2 text-gray-600 hover:bg-gray-50 rounded-lg">
                                    View Analytics
                                </button>
                            </div>
                        </div>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</div>

<!-- Edit Review Modal -->
<div id="editReviewModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" onclick="closeEditReview(event)">
    <div class="bg-white rounded-lg shadow-lg p-6 max-w-md w-full mx-4" onclick="event.stopPropagation()">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Edit Review</h3>

        <form id="editReviewForm" method="POST">
            @csrf
            @method('PATCH')

            <!-- Rating -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                <div class="flex gap-2">
                    <input type="hidden" id="ratingInput" name="rating" value="5">
                    @for($i = 1; $i <= 5; $i++)
                        <button type="button" class="rating-btn text-3xl text-gray-300 hover:text-yellow-400 transition-colors"
                                data-rating="{{ $i }}"
                                onclick="setRating({{ $i }})">
                            ★
                        </button>
                    @endfor
                </div>
            </div>

            <!-- Comment -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Comment (Optional)</label>
                <textarea name="comment" id="commentInput" rows="4"
                         class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                         placeholder="Share your experience..."></textarea>
            </div>

            <!-- Buttons -->
            <div class="flex gap-3">
                <button type="button" onclick="closeEditReview()" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit" class="flex-1 px-4 py-2 bg-purple-600 text-white rounded-lg font-medium hover:bg-purple-700">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function editReview(reviewId, rating, comment) {
    const modal = document.getElementById('editReviewModal');
    const form = document.getElementById('editReviewForm');
    const ratingInput = document.getElementById('ratingInput');
    const commentInput = document.getElementById('commentInput');

    // Set form action
    form.action = "{{ route('noccea.business.reviews.update', ':review') }}".replace(':review', reviewId);

    // Set current values
    ratingInput.value = rating;
    commentInput.value = comment;

    // Update rating buttons
    setRating(rating);

    // Show modal
    modal.classList.remove('hidden');
}

function closeEditReview(event) {
    if (event && event.target.id !== 'editReviewModal') {
        return;
    }
    document.getElementById('editReviewModal').classList.add('hidden');
}

function setRating(rating) {
    document.getElementById('ratingInput').value = rating;

    // Update button styling
    document.querySelectorAll('.rating-btn').forEach((btn, index) => {
        if (index < rating) {
            btn.classList.remove('text-gray-300');
            btn.classList.add('text-yellow-400');
        } else {
            btn.classList.remove('text-yellow-400');
            btn.classList.add('text-gray-300');
        }
    });
}

// Close modal on Escape key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        closeEditReview();
    }
});
</script>
@endsection
