@extends('noccea.community.layout')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <h1 class="text-3xl font-bold text-gray-900">Community Members</h1>
            <p class="text-gray-600 mt-1">Meet and connect with our community</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Search and Filter -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <form method="GET" class="flex flex-col sm:flex-row gap-4">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Search members..."
                       class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent">

                <select name="sort" class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    <option value="active" {{ request('sort') == 'active' ? 'selected' : '' }}>Most Active</option>
                    <option value="discussions" {{ request('sort') == 'discussions' ? 'selected' : '' }}>Most Discussions</option>
                    <option value="replies" {{ request('sort') == 'replies' ? 'selected' : '' }}>Most Replies</option>
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                </select>

                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-green-700 transition">
                    Filter
                </button>
            </form>
        </div>

        <!-- Members Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($members as $member)
                <div class="bg-white rounded-lg shadow hover:shadow-md transition p-6">
                    <div class="text-center">
                        <!-- Avatar -->
                        <div class="w-16 h-16 bg-gradient-to-br from-green-400 to-blue-500 rounded-full flex items-center justify-center mx-auto mb-4">
                            @if($member->profile_picture)
                                <img src="{{ $member->profile_picture }}" alt="{{ $member->username }}" class="w-16 h-16 rounded-full object-cover">
                            @else
                                <span class="text-white font-semibold text-lg">
                                    {{ substr($member->username, 0, 1) }}
                                </span>
                            @endif
                        </div>

                        <!-- Name -->
                        <h3 class="text-lg font-semibold text-gray-900 mb-1">
                            {{ $member->username }}
                        </h3>

                        <!-- Full Name -->
                        @if($member->full_name && $member->full_name !== $member->username)
                            <p class="text-gray-500 text-sm mb-3">{{ $member->full_name }}</p>
                        @endif

                        <!-- Bio -->
                        @if($member->bio)
                            <p class="text-gray-600 text-sm line-clamp-2 mb-4">{{ $member->bio }}</p>
                        @endif

                        <!-- Stats -->
                        <div class="flex justify-center space-x-4 mb-4 text-sm text-gray-500">
                            <div class="text-center">
                                <div class="font-semibold text-gray-900">{{ $member->discussions_count }}</div>
                                <div>Discussions</div>
                            </div>
                            <div class="text-center">
                                <div class="font-semibold text-gray-900">{{ $member->discussion_replies_count }}</div>
                                <div>Replies</div>
                            </div>
                        </div>

                        <!-- View Profile Button -->
                        <a href="{{ route('noccea.community.members.show', $member) }}"
                           class="inline-block bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-700 transition">
                            View Profile
                        </a>

                        <!-- Member Since -->
                        <p class="text-xs text-gray-400 mt-3">
                            Member since {{ $member->created_at->format('M Y') }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-lg shadow p-12 text-center">
                    <div class="text-gray-400 text-5xl mb-4">👥</div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No members found</h3>
                    <p class="text-gray-600">Try adjusting your search criteria.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($members->hasPages())
            <div class="mt-8">
                {{ $members->links() }}
            </div>
        @endif
    </div>
</div>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection
