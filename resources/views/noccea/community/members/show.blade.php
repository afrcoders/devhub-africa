@extends('noccea.community.layout')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Profile Header -->
        <div class="bg-white rounded-lg shadow p-8 mb-8">
            <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                <!-- Avatar -->
                <div class="w-24 h-24 bg-gradient-to-br from-green-400 to-blue-500 rounded-full flex items-center justify-center flex-shrink-0">
                    @if($user->profile_picture)
                        <img src="{{ $user->profile_picture }}" alt="{{ $user->full_name ?: $user->username }}" class="w-24 h-24 rounded-full object-cover">
                    @else
                        <span class="text-white font-bold text-2xl">
                            {{ substr($user->full_name ?: $user->username, 0, 1) }}
                        </span>
                    @endif
                </div>

                <!-- User Info -->
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">
                        {{ $user->full_name ?: $user->username }}
                    </h1>

                    @if($user->full_name && $user->username && $user->full_name !== $user->username)
                        <p class="text-gray-600 text-lg mb-2">{{ '@' . $user->username }}</p>
                    @endif

                    @if($user->bio)
                        <p class="text-gray-700 mb-4">{{ $user->bio }}</p>
                    @endif

                    <div class="flex flex-wrap gap-4 text-sm text-gray-500">
                        @if($user->country)
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                {{ $user->country }}
                            </span>
                        @endif

                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Joined {{ $user->created_at->format('F Y') }}
                        </span>

                        @if($user->last_login)
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Active {{ $user->last_login->diffForHumans() }}
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-2 gap-4 text-center">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="text-2xl font-bold text-gray-900">{{ $user->discussions_count }}</div>
                        <div class="text-sm text-gray-600">Discussions</div>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="text-2xl font-bold text-gray-900">{{ $user->discussion_replies_count }}</div>
                        <div class="text-sm text-gray-600">Replies</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Tabs -->
        <div class="bg-white rounded-lg shadow">
            <div class="border-b border-gray-200">
                <nav class="flex space-x-8 px-6">
                    <button onclick="showTab('discussions')" id="discussions-tab" class="py-4 px-1 border-b-2 font-medium text-sm border-green-500 text-green-600">
                        Recent Discussions
                    </button>
                    <button onclick="showTab('replies')" id="replies-tab" class="py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        Recent Replies
                    </button>
                </nav>
            </div>

            <!-- Discussions Tab -->
            <div id="discussions-content" class="p-6">
                @if($recentDiscussions->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentDiscussions as $discussion)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs">
                                        {{ $discussion->category->name }}
                                    </span>
                                    <span class="text-xs text-gray-500">{{ $discussion->created_at->diffForHumans() }}</span>
                                </div>

                                <h4 class="font-semibold text-gray-900 mb-2">
                                    <a href="{{ route('noccea.community.discussions.show', $discussion) }}" class="hover:text-green-600 transition">
                                        {{ $discussion->title }}
                                    </a>
                                </h4>

                                <div class="flex items-center gap-4 text-sm text-gray-500">
                                    <span>{{ $discussion->replies_count }} replies</span>
                                    <span>{{ $discussion->views_count }} views</span>
                                    <span>{{ $discussion->score }} votes</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="text-gray-400 text-4xl mb-4">💬</div>
                        <p class="text-gray-600">No discussions yet</p>
                    </div>
                @endif
            </div>

            <!-- Replies Tab -->
            <div id="replies-content" class="p-6 hidden">
                @if($recentReplies->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentReplies as $reply)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="text-xs text-gray-500">{{ $reply->created_at->diffForHumans() }}</span>
                                    <span class="text-xs text-gray-400">•</span>
                                    <span class="text-xs text-gray-500">Reply to:</span>
                                </div>

                                <h4 class="font-semibold text-gray-900 mb-2">
                                    <a href="{{ route('noccea.community.discussions.show', $reply->discussion) }}" class="hover:text-green-600 transition">
                                        {{ $reply->discussion->title }}
                                    </a>
                                </h4>

                                <p class="text-gray-600 text-sm line-clamp-3">{{ Str::limit($reply->body, 200) }}</p>

                                <div class="flex items-center gap-4 text-sm text-gray-500 mt-2">
                                    <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs">
                                        {{ $reply->discussion->category->name }}
                                    </span>
                                    <span>{{ $reply->score }} votes</span>
                                    @if($reply->is_best_answer)
                                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-medium">Best Answer</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="text-gray-400 text-4xl mb-4">💭</div>
                        <p class="text-gray-600">No replies yet</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>

<script>
function showTab(tabName) {
    console.log('Switching to tab:', tabName);

    // Hide all content
    const discussionsContent = document.getElementById('discussions-content');
    const repliesContent = document.getElementById('replies-content');

    if (discussionsContent) discussionsContent.classList.add('hidden');
    if (repliesContent) repliesContent.classList.add('hidden');

    // Remove active styles from all tabs
    const discussionsTab = document.getElementById('discussions-tab');
    const repliesTab = document.getElementById('replies-tab');

    if (discussionsTab) {
        discussionsTab.classList.remove('border-green-500', 'text-green-600');
        discussionsTab.classList.add('border-transparent', 'text-gray-500');
    }

    if (repliesTab) {
        repliesTab.classList.remove('border-green-500', 'text-green-600');
        repliesTab.classList.add('border-transparent', 'text-gray-500');
    }

    // Show selected content and activate tab
    const selectedContent = document.getElementById(tabName + '-content');
    const selectedTab = document.getElementById(tabName + '-tab');

    if (selectedContent) {
        selectedContent.classList.remove('hidden');
    }

    if (selectedTab) {
        selectedTab.classList.remove('border-transparent', 'text-gray-500');
        selectedTab.classList.add('border-green-500', 'text-green-600');
    }
}

// Initialize the first tab on page load
document.addEventListener('DOMContentLoaded', function() {
    showTab('discussions');
});
</script>
@endsection
