@extends('noccea.community.layout')

@section('title', 'My Bookmarks')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">My Bookmarks</h1>
        <p class="text-gray-600">All discussions you've saved for later reading</p>
    </div>

    @if($bookmarkedDiscussions->count() > 0)
        <div class="bg-white rounded-lg shadow">
            @foreach($bookmarkedDiscussions as $discussion)
                <div class="p-6 {{ !$loop->last ? 'border-b border-gray-200' : '' }}">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $discussion->category->color ?? 'gray' }}-100 text-{{ $discussion->category->color ?? 'gray' }}-800">
                                    {{ $discussion->category->name }}
                                </span>
                                @if($discussion->bestReply)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        ✓ Solved
                                    </span>
                                @endif
                                @if($discussion->is_pinned)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        📌 Pinned
                                    </span>
                                @endif
                            </div>

                            <h3 class="text-xl font-semibold text-gray-900 mb-2">
                                <a href="{{ route('noccea.community.discussions.show', $discussion) }}"
                                   class="hover:text-green-600 transition-colors">
                                    {{ $discussion->title }}
                                </a>
                            </h3>

                            <p class="text-gray-600 mb-4 line-clamp-2">
                                {{ Str::limit(strip_tags($discussion->body), 150) }}
                            </p>

                            <div class="flex items-center justify-between text-sm text-gray-500">
                                <div class="flex items-center gap-4">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z"/>
                                        </svg>
                                        {{ $discussion->user->username }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $discussion->replies_count }} {{ Str::plural('reply', $discussion->replies_count) }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $discussion->upvotes_count - $discussion->downvotes_count }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $discussion->created_at->diffForHumans() }}
                                    </span>
                                </div>

                                <button type="button" onclick="toggleBookmark('{{ $discussion->slug }}')"
                                        class="px-3 py-1 text-sm bg-green-100 text-green-700 rounded-lg hover:bg-red-100 hover:text-red-700 transition">
                                    📖 Remove
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $bookmarkedDiscussions->links() }}
        </div>
    @else
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <div class="mb-4">
                <svg class="w-12 h-12 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No bookmarks yet</h3>
            <p class="text-gray-600 mb-6">You haven't bookmarked any discussions yet. Start exploring and save interesting discussions for later!</p>
            <a href="{{ route('noccea.community.discussions.index') }}"
               class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                Browse Discussions
            </a>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
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
            // If bookmark was removed, reload the page to remove it from the list
            if (!data.bookmarked) {
                location.reload();
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
</script>
@endpush
