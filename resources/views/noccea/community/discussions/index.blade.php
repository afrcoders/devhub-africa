@extends('noccea.community.layout')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Discussions</h1>
                    <p class="text-gray-600 mt-1">Join conversations and share your thoughts</p>
                </div>
                @auth
                    <a href="{{ route('noccea.community.discussions.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-green-700 transition">
                        Start Discussion
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Main Content -->
            <div class="lg:w-2/3">
                <!-- Search and Filter -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <form method="GET" class="flex flex-col sm:flex-row gap-4">
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Search discussions..."
                               class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent">

                        <select name="sort" class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <option value="recent" {{ request('sort') == 'recent' ? 'selected' : '' }}>Most Recent</option>
                            <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                        </select>

                        <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-green-700 transition">
                            Filter
                        </button>
                    </form>
                </div>

                <!-- Discussions List -->
                <div class="space-y-4">
                    @forelse($discussions as $discussion)
                        <div class="bg-white rounded-lg shadow hover:shadow-md transition p-6">
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center">
                                        <span class="text-sm font-medium text-gray-600">
                                            {{ substr($discussion->user->full_name ?? $discussion->user->username, 0, 1) }}
                                        </span>
                                    </div>
                                </div>

                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-2">
                                        @if($discussion->is_pinned)
                                            <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs font-medium">Pinned</span>
                                        @endif
                                        <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs">
                                            {{ $discussion->category->name }}
                                        </span>
                                    </div>

                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                        <a href="{{ route('noccea.community.discussions.show', $discussion) }}" class="hover:text-green-600 transition">
                                            {{ $discussion->title }}
                                        </a>
                                    </h3>

                                    <p class="text-gray-600 text-sm line-clamp-2">
                                        {{ Str::limit(strip_tags($discussion->body), 200) }}
                                    </p>

                                    <div class="flex items-center gap-4 mt-4 text-sm text-gray-500">
                                        <span>By {{ $discussion->user->full_name ?? $discussion->user->username }}</span>
                                        <span>{{ $discussion->replies_count }} replies</span>
                                        <span>{{ $discussion->views_count }} views</span>
                                        <span>{{ $discussion->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>

                                <div class="flex-shrink-0 text-center">
                                    <div class="text-lg font-semibold text-gray-900">{{ $discussion->score }}</div>
                                    <div class="text-xs text-gray-500">votes</div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white rounded-lg shadow p-12 text-center">
                            <div class="text-gray-400 text-5xl mb-4">💬</div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No discussions found</h3>
                            <p class="text-gray-600 mb-4">Be the first to start a conversation!</p>
                            @auth
                                <a href="{{ route('noccea.community.discussions.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-green-700 transition">
                                    Start Discussion
                                </a>
                            @endauth
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($discussions->hasPages())
                    <div class="mt-8">
                        {{ $discussions->links() }}
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:w-1/3">
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Categories</h3>
                    <div class="space-y-2">
                        @foreach($categories as $category)
                            <a href="{{ route('noccea.community.categories.show', $category) }}"
                               class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 transition">
                                <div class="flex items-center gap-3">
                                    <span class="text-lg">{{ $category->icon }}</span>
                                    <span class="font-medium text-gray-900">{{ $category->name }}</span>
                                </div>
                                <span class="text-sm text-gray-500">{{ $category->discussions_count }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
