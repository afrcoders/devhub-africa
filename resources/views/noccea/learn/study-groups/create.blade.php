@extends('noccea.learn.layout')

@section('title', 'Create Study Group')

@section('content')
<div class="bg-white min-h-screen">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Create a Study Group</h1>
            <p class="text-gray-600">Start a group to learn with others</p>
        </div>

        @if ($errors->any())
        <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('noccea.learn.study-groups.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Group Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Group Name *</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                    placeholder="e.g., Advanced Python Study Group">
            </div>

            <!-- Category -->
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                <select name="category" id="category" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                    <option value="">Select a category</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                <textarea name="description" id="description" rows="4" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                    placeholder="Describe what your study group will focus on, goals, and expectations...">{{ old('description') }}</textarea>
            </div>

            <!-- Max Members -->
            <div>
                <label for="max_members" class="block text-sm font-medium text-gray-700 mb-2">Maximum Members *</label>
                <input type="number" name="max_members" id="max_members" value="{{ old('max_members', 20) }}"
                    min="2" max="100" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                <p class="mt-1 text-sm text-gray-500">Between 2 and 100 members</p>
            </div>

            <!-- Next Meeting Date (Optional) -->
            <div>
                <label for="next_meeting_at" class="block text-sm font-medium text-gray-700 mb-2">Next Meeting Date (Optional)</label>
                <input type="datetime-local" name="next_meeting_at" id="next_meeting_at" value="{{ old('next_meeting_at') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
            </div>

            <!-- Meeting Link (Optional) -->
            <div>
                <label for="meeting_link" class="block text-sm font-medium text-gray-700 mb-2">Meeting Link (Optional)</label>
                <input type="url" name="meeting_link" id="meeting_link" value="{{ old('meeting_link') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                    placeholder="https://zoom.us/j/...">
                <p class="mt-1 text-sm text-gray-500">Link to Zoom, Google Meet, or other meeting platform</p>
            </div>

            <!-- Buttons -->
            <div class="flex items-center justify-end space-x-4 pt-6">
                <a href="{{ route('noccea.learn.study-groups.index') }}"
                    class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">Cancel</a>
                <button type="submit"
                    class="px-6 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 font-medium">Create Study Group</button>
            </div>
        </form>
    </div>
</div>
@endsection
