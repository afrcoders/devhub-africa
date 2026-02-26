@extends('noccea.learn.layout')

@section('title', $studyGroup->name)

@section('content')
<div class="bg-white min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

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

        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-start mb-4">
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $studyGroup->name }}</h1>
                    <div class="flex items-center space-x-4 text-sm text-gray-600">
                        <span class="inline-block px-3 py-1 bg-orange-100 text-orange-700 rounded-full font-medium">{{ $studyGroup->category }}</span>
                        <span>Created by {{ $studyGroup->creator->name }}</span>
                        <span>{{ $studyGroup->membersCount() }}/{{ $studyGroup->max_members }} Members</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex space-x-3">
                    @auth
                        @if($isAdmin)
                            <a href="{{ route('noccea.learn.study-groups.edit', $studyGroup) }}"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">Edit Group</a>
                            <form action="{{ route('noccea.learn.study-groups.destroy', $studyGroup) }}" method="POST" class="inline"
                                onsubmit="return confirm('Are you sure you want to delete this study group?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm">Delete</button>
                            </form>
                        @elseif($isMember)
                            <form action="{{ route('noccea.learn.study-groups.leave', $studyGroup) }}" method="POST" class="inline"
                                onsubmit="return confirm('Are you sure you want to leave this study group?');">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm">Leave Group</button>
                            </form>
                        @elseif(!$studyGroup->isFull())
                            <form action="{{ route('noccea.learn.study-groups.join', $studyGroup) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 text-sm">Join Group</button>
                            </form>
                        @endif
                    @endauth
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Description -->
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">About This Group</h2>
                    <p class="text-gray-700 whitespace-pre-line">{{ $studyGroup->description }}</p>
                </div>

                <!-- Meeting Info -->
                @if($studyGroup->next_meeting_at || $studyGroup->meeting_link)
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Next Meeting</h2>
                    @if($studyGroup->next_meeting_at)
                    <p class="text-gray-700 mb-2">
                        <span class="font-medium">Date:</span> {{ $studyGroup->next_meeting_at->format('l, F j, Y g:i A') }}
                    </p>
                    @endif
                    @if($studyGroup->meeting_link)
                    <p class="text-gray-700">
                        <span class="font-medium">Link:</span>
                        @if($isMember)
                            <a href="{{ $studyGroup->meeting_link }}" target="_blank" class="text-orange-600 hover:underline">{{ $studyGroup->meeting_link }}</a>
                        @else
                            <span class="text-gray-500 italic">Join the group to see the meeting link</span>
                        @endif
                    </p>
                    @endif
                </div>
                @endif

                <!-- Members Section -->
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Members ({{ $studyGroup->membersCount() }})</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($studyGroup->members as $member)
                        <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-orange-500 rounded-full flex items-center justify-center text-white font-bold">
                                    {{ strtoupper(substr($member->name, 0, 1)) }}
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $member->name }}</p>
                                @if($member->pivot->role === 'admin')
                                <p class="text-xs text-orange-600">Admin</p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Conversation Section -->
                @if($isMember)
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Group Conversation</h2>

                    <!-- Post Message Form -->
                    <form action="{{ route('noccea.learn.study-groups.messages.post', $studyGroup) }}" method="POST" class="mb-6">
                        @csrf
                        <textarea name="message" rows="3" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent resize-none"
                            placeholder="Share your thoughts, ask questions, or start a discussion..."></textarea>
                        <div class="flex justify-end mt-3">
                            <button type="submit" class="px-6 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 font-medium">
                                Post Message
                            </button>
                        </div>
                    </form>

                    <!-- Messages List -->
                    <div class="space-y-4">
                        @forelse($messages as $message)
                        <div class="bg-gray-50 rounded-lg p-4" id="message-{{ $message->id }}">
                            <div class="flex items-start justify-between mb-2">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center text-white text-sm font-bold">
                                        {{ strtoupper(substr($message->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $message->user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $message->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                @if($message->user_id === auth()->id() || $isAdmin)
                                <div class="flex space-x-2">
                                    <button onclick="editMessage({{ $message->id }})" class="text-blue-600 hover:text-blue-800 text-sm">Edit</button>
                                    <form action="{{ route('noccea.learn.study-groups.messages.delete', [$studyGroup, $message]) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Are you sure you want to delete this message?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm">Delete</button>
                                    </form>
                                </div>
                                @endif
                            </div>

                            <!-- Display Mode -->
                            <div id="display-{{ $message->id }}">
                                <p class="text-gray-700 whitespace-pre-wrap">{{ $message->message }}</p>
                            </div>

                            <!-- Edit Mode -->
                            <form id="edit-form-{{ $message->id }}" class="hidden" action="{{ route('noccea.learn.study-groups.messages.update', [$studyGroup, $message]) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <textarea name="message" rows="3" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent resize-none">{{ $message->message }}</textarea>
                                <div class="flex justify-end space-x-2 mt-2">
                                    <button type="button" onclick="cancelEdit({{ $message->id }})" class="px-4 py-1 text-gray-700 border border-gray-300 rounded hover:bg-gray-50 text-sm">Cancel</button>
                                    <button type="submit" class="px-4 py-1 bg-orange-600 text-white rounded hover:bg-orange-700 text-sm">Save</button>
                                </div>
                            </form>
                        </div>
                        @empty
                        <div class="text-center py-8 text-gray-500">
                            <p>No messages yet. Be the first to start the conversation!</p>
                        </div>
                        @endforelse
                    </div>
                </div>
                @else
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Group Conversation</h2>
                    <div class="text-center py-8">
                        <p class="text-gray-600 mb-4">Join this study group to participate in the conversation</p>
                        @auth
                            @if(!$studyGroup->isFull())
                            <form action="{{ route('noccea.learn.study-groups.join', $studyGroup) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="px-6 py-3 bg-orange-600 text-white rounded-lg hover:bg-orange-700 font-medium">Join Group</button>
                            </form>
                            @endif
                        @else
                            <a href="{{ route('noccea.learn.login') }}" class="px-6 py-3 bg-orange-600 text-white rounded-lg hover:bg-orange-700 font-medium inline-block">Sign In to Join</a>
                        @endauth
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Quick Stats -->
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Group Info</h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-600">Created</p>
                            <p class="font-medium">{{ $studyGroup->created_at->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Category</p>
                            <p class="font-medium">{{ $studyGroup->category }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Members</p>
                            <p class="font-medium">{{ $studyGroup->membersCount() }} / {{ $studyGroup->max_members }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Status</p>
                            <p class="font-medium">
                                @if($studyGroup->is_active)
                                    <span class="text-green-600">Active</span>
                                @else
                                    <span class="text-gray-600">Inactive</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Back Button -->
                <a href="{{ route('noccea.learn.study-groups.index') }}"
                    class="block w-full px-4 py-2 text-center border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                    Back to All Groups
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function editMessage(messageId) {
    // Hide display mode, show edit form
    document.getElementById('display-' + messageId).classList.add('hidden');
    document.getElementById('edit-form-' + messageId).classList.remove('hidden');
}

function cancelEdit(messageId) {
    // Show display mode, hide edit form
    document.getElementById('display-' + messageId).classList.remove('hidden');
    document.getElementById('edit-form-' + messageId).classList.add('hidden');
}
</script>
@endsection
