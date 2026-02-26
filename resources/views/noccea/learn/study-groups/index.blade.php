@extends('noccea.learn.layout')

@section('title', 'Study Groups')

@section('content')
<div class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Study Groups</h1>
            <p class="text-xl text-gray-600">Join groups of learners studying similar topics</p>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
        <div class="mb-8 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="mb-8 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
            {{ session('error') }}
        </div>
        @endif

        <!-- Filter and Create Group -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <select id="categoryFilter" onchange="filterGroups()" class="px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>
            @auth
                @if(auth()->user()->role === 'admin')
                <a href="{{ route('noccea.learn.study-groups.create') }}" class="px-6 py-3 bg-orange-600 text-white rounded-lg hover:bg-orange-700 font-medium">Create Study Group</a>
                @endif
            @endauth
        </div>

        <!-- Study Groups List -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($studyGroups as $group)
            <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-lg transition">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <a href="{{ route('noccea.learn.study-groups.show', $group) }}" class="text-lg font-bold text-gray-900 hover:text-orange-600">{{ $group->name }}</a>
                        <p class="text-gray-600 text-sm">{{ $group->category }}</p>
                        <p class="text-gray-500 text-xs mt-1">Created by {{ $group->creator->name }}</p>
                    </div>
                    <span class="inline-block px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-sm font-medium">{{ $group->membersCount() }}/{{ $group->max_members }} Members</span>
                </div>
                <p class="text-gray-600 mb-4 text-sm line-clamp-2">{{ $group->description }}</p>
                <div class="flex items-center justify-between">
                    @if($group->next_meeting_at)
                    <span class="text-xs text-gray-500">Next meeting: {{ $group->next_meeting_at->format('M d, Y g:i A') }}</span>
                    @else
                    <span class="text-xs text-gray-500">No meeting scheduled</span>
                    @endif

                    @auth
                        @if($group->isMember(auth()->id()))
                            <a href="{{ route('noccea.learn.study-groups.show', $group) }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm">View</a>
                        @elseif($group->isFull())
                            <button disabled class="px-4 py-2 bg-gray-300 text-gray-600 rounded-lg cursor-not-allowed text-sm">Full</button>
                        @else
                            <form action="{{ route('noccea.learn.study-groups.join', $group) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 text-sm">Join</button>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('noccea.learn.login') }}" class="px-4 py-2 text-orange-600 border border-orange-600 rounded-lg hover:bg-orange-50 text-sm">Sign In</a>
                    @endauth
                </div>
            </div>
            @empty
            <div class="col-span-2 text-center py-12">
                <p class="text-gray-500 text-lg mb-4">No study groups available yet</p>
                @auth
                    @if(auth()->user()->role === 'admin')
                    <a href="{{ route('noccea.learn.study-groups.create') }}" class="px-6 py-3 bg-orange-600 text-white rounded-lg hover:bg-orange-700 font-medium inline-block">Create the First Study Group</a>
                    @endif
                @endauth
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($studyGroups->hasPages())
        <div class="mt-12">
            {{ $studyGroups->links() }}
        </div>
        @endif
    </div>
</div>

<script>
function filterGroups() {
    const category = document.getElementById('categoryFilter').value;
    const url = new URL(window.location.href);

    if (category) {
        url.searchParams.set('category', category);
    } else {
        url.searchParams.delete('category');
    }

    window.location.href = url.toString();
}
</script>
@endsection
