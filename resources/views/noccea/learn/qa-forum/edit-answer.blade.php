@extends('noccea.learn.layout')

@section('title', 'Edit Answer - Q&A Forum')

@section('content')
<div class="bg-gray-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Link -->
        <a href="{{ route('noccea.learn.qa-forum.show', $question) }}" class="text-orange-600 hover:text-orange-700 font-semibold mb-6 inline-block">
            ← Back to Question
        </a>

        <!-- Edit Answer Form -->
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Edit Your Answer</h1>
            <p class="text-gray-600 mb-8">Question: {{ $question->title }}</p>

            <form action="{{ route('noccea.learn.qa-forum.answer.update', [$question, $answer]) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="mb-6">
                    <label for="body" class="block text-sm font-semibold text-gray-900 mb-2">
                        Answer
                    </label>
                    <textarea id="body" name="body" rows="12"
                              placeholder="Provide a detailed answer..."
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 @error('body') border-red-500 @enderror"
                              required>{{ old('body', $answer->body) }}</textarea>
                    @error('body')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="px-8 py-3 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition font-semibold">
                        Update Answer
                    </button>
                    <a href="{{ route('noccea.learn.qa-forum.show', $question) }}" class="px-8 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-semibold">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
