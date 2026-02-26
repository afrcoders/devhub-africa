@extends('noccea.community.layout')

@push('head')
<style>
.discussion-content {
    line-height: 1.7;
}
.discussion-content h1, .discussion-content h2, .discussion-content h3 {
    margin-top: 1.5rem;
    margin-bottom: 0.75rem;
    font-weight: 600;
}
.discussion-content p {
    margin-bottom: 1rem;
}
.discussion-content ul, .discussion-content ol {
    margin: 1rem 0;
    padding-left: 2rem;
}
.discussion-content blockquote {
    border-left: 4px solid #d1d5db;
    padding-left: 1rem;
    margin: 1rem 0;
    font-style: italic;
    color: #6b7280;
}
.discussion-content code {
    background-color: #f3f4f6;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    font-family: monospace;
    font-size: 0.875rem;
}
</style>
@endpush

@push('head')
<style>
/* Ensure Summernote editor takes full width */
.note-editor {
    width: 100% !important;
}
.note-editor .note-editing-area {
    width: 100% !important;
}
.note-editor .note-editable {
    width: 100% !important;
    min-width: 100% !important;
}
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Discussion Header -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="p-6 border-b border-gray-200">
                <!-- Breadcrumb -->
                <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
                    <a href="{{ route('noccea.community.home') }}" class="hover:text-gray-700">Community</a>
                    <span>/</span>
                    <a href="{{ route('noccea.community.discussions.index') }}" class="hover:text-gray-700">Discussions</a>
                    <span>/</span>
                    <a href="{{ route('noccea.community.categories.show', $discussion->category) }}" class="hover:text-gray-700">{{ $discussion->category->name }}</a>
                </div>

                <!-- Category Badge -->
                <div class="flex items-center gap-2 mb-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        @if($discussion->category->icon)
                            <span class="mr-1">{{ $discussion->category->icon }}</span>
                        @endif
                        {{ $discussion->category->name }}
                    </span>
                    @if($discussion->is_pinned)
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            📌 Pinned
                        </span>
                    @endif
                </div>

                <!-- Title -->
                <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $discussion->title }}</h1>

                <!-- Meta Info -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4 text-sm text-gray-600">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-gradient-to-br from-green-400 to-blue-500 rounded-full flex items-center justify-center">
                                @if($discussion->user->profile_picture)
                                    <img src="{{ $discussion->user->profile_picture }}" alt="{{ $discussion->user->full_name ?: $discussion->user->username }}" class="w-8 h-8 rounded-full object-cover">
                                @else
                                    <span class="text-white font-semibold text-sm">
                                        {{ substr($discussion->user->full_name ?: $discussion->user->username, 0, 1) }}
                                    </span>
                                @endif
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">{{ $discussion->user->full_name ?: $discussion->user->username }}</p>
                                <p class="text-xs text-gray-500">{{ $discussion->created_at->format('M j, Y \a\t g:i A') }}</p>
                            </div>
                        </div>
                        <span>•</span>
                        <span>{{ $discussion->replies_count }} {{ Str::plural('reply', $discussion->replies_count) }}</span>
                        <span>•</span>
                        <span>{{ $discussion->views_count ?? 0 }} {{ Str::plural('view', $discussion->views_count ?? 0) }}</span>
                    </div>

                    <!-- Actions -->
                    @auth
                        <div class="flex items-center gap-2">
                            @can('update', $discussion)
                                <a href="{{ route('noccea.community.discussions.edit', $discussion) }}"
                                   class="px-3 py-1 text-sm bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                                    Edit
                                </a>
                            @endcan
                            @can('delete', $discussion)
                                <button onclick="deleteDiscussion({{ $discussion->id }})"
                                        class="px-3 py-1 text-sm bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition">
                                    Delete
                                </button>
                            @endcan
                            <button type="button" onclick="toggleBookmark('{{ $discussion->slug }}')"
                                    class="px-3 py-1 text-sm {{ isset($isBookmarked) && $isBookmarked ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }} rounded-lg hover:bg-gray-200 transition">
                                📖 {{ isset($isBookmarked) && $isBookmarked ? 'Saved' : 'Save' }}
                            </button>

                            {{-- Social Share Button --}}
                            <div class="relative">
                                @include('shared.social-share', [
                                    'url' => request()->url(),
                                    'title' => $discussion->title,
                                    'type' => 'discussion',
                                    'position' => 'top-full right-0'
                                ])
                            </div>
                        </div>
                    @endauth
                </div>
            </div>

            <!-- Discussion Content -->
            <div class="p-6">
                <div class="discussion-content prose prose-gray max-w-none">
                    {!! $discussion->body !!}
                </div>

                <!-- Voting -->
                @auth
                    <div class="flex items-center gap-4 mt-6 pt-6 border-t border-gray-200">
                        <div class="flex items-center gap-2">
                            <button onclick="vote('{{ $discussion->slug }}', 'up')" class="flex items-center gap-1 px-3 py-1 text-sm bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition">
                                👍 Helpful ({{ $discussion->upvotes_count ?? 0 }})
                            </button>
                            <button onclick="vote('{{ $discussion->slug }}', 'down')" class="flex items-center gap-1 px-3 py-1 text-sm bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition">
                                👎 Not Helpful ({{ $discussion->downvotes_count ?? 0 }})
                            </button>
                        </div>
                    </div>
                @endauth
            </div>
        </div>

        <!-- Replies Section -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">
                    {{ $discussion->replies_count }} {{ Str::plural('Reply', $discussion->replies_count) }}
                </h2>
            </div>

            <!-- Add Reply Button -->
            @auth
                <div class="p-6 border-b border-gray-200 bg-gray-50 text-center">
                    <div class="max-w-md mx-auto">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Join the Discussion</h3>
                        <p class="text-gray-600 mb-4">Share your thoughts, insights, or questions with the community.</p>
                        <a href="{{ route('noccea.community.discussions.replies.create', $discussion) }}"
                           class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Write a Reply
                        </a>
                    </div>
                </div>
            @else
                <div class="p-6 border-b border-gray-200 bg-gray-50 text-center">
                    <p class="text-gray-600">
                        <a href="{{ route('id.auth.unified', ['return' => request()->fullUrl()]) }}" class="text-green-600 hover:text-green-700 font-medium">
                            Sign in
                        </a> to join the conversation
                    </p>
                </div>
            @endauth

            <!-- Replies List -->
            @if($discussion->replies && $discussion->replies->count() > 0)
                <div class="divide-y divide-gray-200">
                    @foreach($discussion->replies as $reply)
                        <div class="p-6" data-reply-id="{{ $reply->id }}">
                            <div class="flex gap-4">
                                <!-- Avatar -->
                                <div class="w-10 h-10 bg-gradient-to-br from-green-400 to-blue-500 rounded-full flex items-center justify-center flex-shrink-0">
                                    @if($reply->user->profile_picture)
                                        <img src="{{ $reply->user->profile_picture }}" alt="{{ $reply->user->full_name ?: $reply->user->username }}" class="w-10 h-10 rounded-full object-cover">
                                    @else
                                        <span class="text-white font-semibold">
                                            {{ substr($reply->user->full_name ?: $reply->user->username, 0, 1) }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Reply Content -->
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <h4 class="font-medium text-gray-900">{{ $reply->user->full_name ?: $reply->user->username }}</h4>
                                        <span class="text-sm text-gray-500">{{ $reply->created_at->diffForHumans() }}</span>
                                        @if($reply->is_best_answer)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                ✓ Best Answer
                                            </span>
                                        @endif
                                    </div>

                                    <div class="discussion-content prose prose-gray prose-sm max-w-none">
                                        {!! $reply->body !!}
                                    </div>

                                    <!-- Reply Actions -->
                                    @auth
                                        <div class="flex items-center gap-3 mt-3">
                                            <button onclick="voteReply({{ $reply->id }}, 'up')" class="text-sm text-green-600 hover:text-green-700">👍 Helpful ({{ $reply->upvotes_count ?? 0 }})</button>
                                            <button onclick="voteReply({{ $reply->id }}, 'down')" class="text-sm text-red-600 hover:text-red-700">👎 ({{ $reply->downvotes_count ?? 0 }})</button>
                                            @if(auth()->id() === $discussion->user_id && !$reply->is_best_answer)
                                                <button onclick="markBestAnswer({{ $reply->id }})" class="text-sm text-green-600 hover:text-green-700">
                                                    Mark as Best Answer
                                                </button>
                                            @endif

                                            <!-- Edit and Delete buttons for replies -->
                                            @can('update', $reply)
                                                <a href="{{ route('noccea.community.replies.edit', $reply) }}" class="text-sm text-blue-600 hover:text-blue-700">
                                                    Edit
                                                </a>
                                            @endcan
                                            @can('delete', $reply)
                                                <button onclick="deleteReply({{ $reply->id }})" class="text-sm text-red-600 hover:text-red-700">
                                                    Delete
                                                </button>
                                            @endcan
                                        </div>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-12 text-center text-gray-500">
                    <div class="text-4xl mb-4">💭</div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No replies yet</h3>
                    <p>Be the first to share your thoughts on this discussion.</p>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<!-- Summernote JS -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<script>
function vote(discussionSlug, type) {
    const voteType = type === 'up' ? 'upvote' : 'downvote';

    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    const formData = new FormData();

    if (csrfToken) {
        formData.append('_token', csrfToken.getAttribute('content'));
    }
    formData.append('type', voteType);

    // Determine the correct URL based on current domain
    let voteUrl;
    if (window.location.hostname === 'community.noccea.test') {
        voteUrl = `/discussions/${discussionSlug}/vote`;
    } else {
        voteUrl = `/community/discussions/${discussionSlug}/vote`;
    }

    fetch(voteUrl, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update the vote counts
            const upButton = document.querySelector(`button[onclick="vote('${discussionSlug}', 'up')"]`);
            const downButton = document.querySelector(`button[onclick="vote('${discussionSlug}', 'down')"]`);

            if (upButton) {
                upButton.innerHTML = `👍 Helpful (${data.upvotes || 0})`;
            }
            if (downButton) {
                downButton.innerHTML = `👎 Not Helpful (${data.downvotes || 0})`;
            }
        } else {
            alert('Error voting: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Network error occurred');
    });
}

function toggleBookmark(discussionSlug) {
    // Check if user is authenticated
    if (!document.querySelector('meta[name="csrf-token"]')) {
        alert('Please log in to bookmark discussions.');
        return;
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    const formData = new FormData();

    if (csrfToken) {
        formData.append('_token', csrfToken.getAttribute('content'));
    }

    // Determine the correct URL based on current domain
    let bookmarkUrl;
    if (window.location.hostname === 'community.noccea.test') {
        bookmarkUrl = `/discussions/${discussionSlug}/bookmark`;
    } else {
        bookmarkUrl = `/community/discussions/${discussionSlug}/bookmark`;
    }

    fetch(bookmarkUrl, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update the button text and style based on bookmark status
            const button = document.querySelector(`button[onclick="toggleBookmark('${discussionSlug}')"`);
            if (button) {
                if (data.bookmarked) {
                    button.innerHTML = '📖 Saved';
                    button.classList.remove('bg-gray-100', 'text-gray-700');
                    button.classList.add('bg-green-100', 'text-green-700');
                } else {
                    button.innerHTML = '📖 Save';
                    button.classList.remove('bg-green-100', 'text-green-700');
                    button.classList.add('bg-gray-100', 'text-gray-700');
                }
            }
        } else {
            alert('Error bookmarking discussion: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Network error occurred');
    });
}

function markBestAnswer(replyId) {
    // Implement best answer functionality
    console.log('Mark best answer:', replyId);
    // You can add AJAX call here
}

// Reply edit functionality - now redirects to separate page
function editReply(replyId) {
    // This function is kept for compatibility but should no longer be used
    // since we now have separate edit pages
    console.log('Redirecting to edit page for reply:', replyId);
    // The actual edit link should handle this redirection
}

function cancelEditReply(replyId) {
    // This function is no longer needed since we use separate pages
    console.log('cancelEditReply called but not needed with separate pages');
}

function updateReply(event, replyId) {
    // This function is no longer needed since we use separate pages
    console.log('updateReply called but not needed with separate pages');
}

// Reply delete functionality
function deleteReply(replyId) {
    if (!confirm('Are you sure you want to delete this reply? This action cannot be undone.')) {
        return;
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    const formData = new FormData();

    if (csrfToken) {
        formData.append('_token', csrfToken.getAttribute('content'));
    }
    formData.append('_method', 'DELETE');

    // Determine the correct URL based on current domain
    let deleteUrl;
    if (window.location.hostname === 'community.noccea.test') {
        deleteUrl = `/replies/${replyId}`;
    } else {
        deleteUrl = `/community/replies/${replyId}`;
    }

    fetch(deleteUrl, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success || data.status === 'success') {
            location.reload();
        } else {
            alert('Error deleting reply: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // Fallback: try to redirect even if AJAX fails
        location.reload();
    });
}

// Discussion delete functionality
function deleteDiscussion(discussionId) {
    if (!confirm('Are you sure you want to delete this discussion? This action cannot be undone and will also delete all replies.')) {
        return;
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    const formData = new FormData();

    if (csrfToken) {
        formData.append('_token', csrfToken.getAttribute('content'));
    }
    formData.append('_method', 'DELETE');

    // Determine the correct URL based on current domain
    let deleteUrl;
    if (window.location.hostname === 'community.noccea.test') {
        deleteUrl = `/discussions/${discussionId}`;
    } else {
        deleteUrl = `/community/discussions/${discussionId}`;
    }

    fetch(deleteUrl, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
        }
    })
    .then(response => {
        if (response.redirected) {
            window.location.href = response.url;
        } else {
            return response.json();
        }
    })
    .then(data => {
        if (data && (data.success || data.status === 'success')) {
            window.location.href = '/discussions';
        } else if (data && data.redirect) {
            window.location.href = data.redirect;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // Fallback: redirect to discussions index
        window.location.href = '/discussions';
    });
}

// Reply voting functionality
function voteReply(replyId, type) {
    const voteType = type === 'up' ? 'upvote' : 'downvote';

    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    const formData = new FormData();

    if (csrfToken) {
        formData.append('_token', csrfToken.getAttribute('content'));
    }
    formData.append('type', voteType);

    // Determine the correct URL based on current domain
    let voteUrl;
    if (window.location.hostname === 'community.noccea.test') {
        voteUrl = `/replies/${replyId}/vote`;
    } else {
        voteUrl = `/community/replies/${replyId}/vote`;
    }

    fetch(voteUrl, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update the vote counts
            const upButton = document.querySelector(`button[onclick="voteReply(${replyId}, 'up')"]`);
            const downButton = document.querySelector(`button[onclick="voteReply(${replyId}, 'down')"]`);

            if (upButton) {
                upButton.innerHTML = `👍 Helpful (${data.upvotes || 0})`;
            }
            if (downButton) {
                downButton.innerHTML = `👎 (${data.downvotes || 0})`;
            }
        } else {
            alert('Error voting: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Network error occurred');
    });
}

// Initialize page - no inline forms to initialize since we use separate pages
$(document).ready(function() {
    console.log('Discussion show page initialized');
    console.log('Reply creation and editing now handled on separate pages with proper Summernote integration');
});
</script>
@endpush
@endsection
