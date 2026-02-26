@extends('noccea.learn.layout')

@section('title', 'Q&A Forum')

@section('content')
<div class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Q&A Forum</h1>
            <p class="text-xl text-gray-600">Ask questions and help fellow learners</p>
        </div>

        <!-- Ask Question Button -->
        @auth
        <div class="mb-8">
            <a href="{{ route('noccea.learn.qa-forum.create') }}" class="inline-block px-6 py-3 bg-orange-600 text-white rounded-lg hover:bg-orange-700 font-medium transition">
                + Ask a Question
            </a>
        </div>
        @else
        <div class="mb-8 bg-orange-50 border border-orange-200 rounded-lg p-4 text-center">
            <a href="{{ route('noccea.learn.login') }}" class="inline-block text-orange-600 hover:text-orange-700 font-medium">Sign in to ask questions</a>
        </div>
        @endauth

        <!-- Questions List -->
        <div class="space-y-4">
            @forelse($questions as $question)
            <a href="{{ route('noccea.learn.qa-forum.show', $question) }}" class="block">
                <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-lg transition">
                    <div class="flex gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                @if($question->isAnswered())
                                <span class="inline-block px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-medium">✓ Answered</span>
                                @else
                                <span class="inline-block px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-xs font-medium">Open</span>
                                @endif
                                <span class="text-sm text-gray-500">{{ $question->answers->count() }} answers</span>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2 hover:text-orange-600">
                                {{ $question->title }}
                            </h3>
                            <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $question->body }}</p>
                            <div class="flex items-center gap-3 text-xs text-gray-500">
                                <span>Asked by {{ $question->user->name ?? 'Anonymous' }}</span>
                                <span>•</span>
                                <span>{{ $question->created_at->diffForHumans() }}</span>
                                <span>•</span>
                                <span>{{ $question->views }} views</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-bold text-orange-600">{{ $question->votes }}</div>
                            <div class="text-xs text-gray-500">votes</div>
                        </div>
                    </div>
                </div>
            </a>
            @empty
            <div class="text-center py-12">
                <p class="text-gray-500">No questions yet. Be the first to ask!</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
