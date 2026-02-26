@extends('noccea.community.layout')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center gap-4">
                <div class="text-2xl">{{ $category->icon }}</div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $category->name }}</h1>
                    <p class="text-gray-600 mt-1">{{ $category->description }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Search and Filter -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <form method="GET" class="flex flex-col sm:flex-row gap-4">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Search in {{ $category->name }}..."
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
                            @if($discussion->is_pinned)
                                <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs font-medium mb-2 inline-block">Pinned</span>
                            @endif

                            <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                <a href="{{ route('noccea.community.discussions.show', $discussion) }}" class="hover:text-green-600 transition">
                                    {{ $discussion->title }}
                                </a>
                            </h3>

                            <p class="text-gray-600 text-sm line-clamp-2 mb-4">
                                {{ Str::limit(strip_tags($discussion->body), 200) }}
                            </p>

                            <div class="flex items-center gap-4 text-sm text-gray-500">
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
                    <div class="text-gray-400 text-5xl mb-4">{{ $category->icon }}</div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No discussions in {{ $category->name }} yet</h3>
                    <p class="text-gray-600 mb-4">Be the first to start a conversation in this category!</p>
                    @auth
                        <a href="{{ route('noccea.community.discussions.create', ['category' => $category->slug]) }}"
                           class="bg-green-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-green-700 transition">
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
</div>
@endsection
