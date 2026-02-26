@extends('noccea.learn.layout')

@section('title', 'Ask a Question - Q&A Forum')

@section('content')
<div class="bg-white py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('noccea.learn.qa-forum.index') }}" class="text-orange-600 hover:text-orange-700 font-semibold mb-4 inline-block">
                ← Back to Q&A Forum
            </a>
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Ask a Question</h1>
            <p class="text-gray-600">Help from the community is just a question away</p>
        </div>

        <!-- Form -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-lg p-8">
            <form action="{{ route('noccea.learn.qa-forum.store') }}" method="POST">
                @csrf

                <!-- Title -->
                <div class="mb-6">
                    <label for="title" class="block text-sm font-semibold text-gray-900 mb-2">
                        Question Title
                    </label>
                    <input type="text" id="title" name="title"
                           placeholder="What's your question? Be specific and clear..."
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 @error('title') border-red-500 @enderror"
                           value="{{ old('title') }}" required>
                    @error('title')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                    <p class="text-sm text-gray-500 mt-2">Minimum 10 characters. Be descriptive to get better answers.</p>
                </div>

                <!-- Category/Course -->
                <div class="mb-6">
                    <label for="course_id" class="block text-sm font-semibold text-gray-900 mb-2">
                        Related Course (Optional)
                    </label>
                    <select id="course_id" name="course_id"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                        <option value="">-- Select a course --</option>
                        @php
                            $courses = \App\Models\Noccea\Learn\Course::orderBy('title')->get();
                        @endphp
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->title }}</option>
                        @endforeach
                    </select>
                    <p class="text-sm text-gray-500 mt-2">Select a course if your question is related to a specific course.</p>
                </div>

                <!-- Body -->
                <div class="mb-6">
                    <label for="body" class="block text-sm font-semibold text-gray-900 mb-2">
                        Question Details
                    </label>
                    <textarea id="body" name="body" rows="10"
                              placeholder="Provide details about your question. Include what you've tried, any error messages, and relevant code snippets if applicable..."
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 @error('body') border-red-500 @enderror"
                              required>{{ old('body') }}</textarea>
                    @error('body')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                    <p class="text-sm text-gray-500 mt-2">Minimum 20 characters. More details = better answers!</p>
                </div>

                <!-- Tips -->
                <div class="mb-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
                    <h3 class="font-semibold text-blue-900 mb-3">Tips for a great question:</h3>
                    <ul class="space-y-2 text-sm text-blue-800">
                        <li>✓ Use a clear, descriptive title</li>
                        <li>✓ Provide context and what you've tried</li>
                        <li>✓ Include error messages or code snippets</li>
                        <li>✓ Be specific about what you're trying to achieve</li>
                        <li>✓ Avoid duplicate questions - search first</li>
                    </ul>
                </div>

                <!-- Buttons -->
                <div class="flex gap-3">
                    <button type="submit" class="px-8 py-3 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition font-semibold">
                        Post Question
                    </button>
                    <a href="{{ route('noccea.learn.qa-forum.index') }}" class="px-8 py-3 bg-gray-200 text-gray-900 rounded-lg hover:bg-gray-300 transition font-semibold">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
