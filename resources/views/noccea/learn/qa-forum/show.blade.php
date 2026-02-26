@extends('noccea.learn.layout')

@section('title', $question->title . ' - Q&A Forum')

@section('content')
<div class="bg-gray-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Link -->
        <a href="{{ route('noccea.learn.qa-forum.index') }}" class="text-orange-600 hover:text-orange-700 font-semibold mb-6 inline-block">
            ← Back to Q&A Forum
        </a>

        <!-- Question -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
            <div class="mb-6">
                <div class="flex items-center gap-2 mb-3">
                    @if($question->isAnswered())
                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded text-sm font-semibold">✓ Answered</span>
                    @else
                    <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded text-sm font-semibold">Open</span>
                    @endif
                    @if($question->course)
                    <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded text-sm font-medium">{{ $question->course->category }}</span>
                    @endif
                </div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $question->title }}</h1>
            </div>

            <!-- Question Meta -->
            <div class="flex items-center gap-4 text-sm text-gray-600 mb-6 pb-6 border-b border-gray-200">
                <span>Asked by <strong>{{ $question->user->name ?? 'Anonymous' }}</strong></span>
                <span>•</span>
                <span>{{ $question->created_at->format('M d, Y H:i') }}</span>
                <span>•</span>
                <span>{{ $question->views }} views</span>
            </div>

            <!-- Question Body -->
            <div class="prose max-w-none mb-8">
                {!! nl2br(e($question->body)) !!}
            </div>

            <!-- Question Actions Row -->
            <div class="flex flex-wrap gap-4 pt-6 border-t border-gray-200">
                <!-- Voting Buttons -->
                @auth
                <div class="flex gap-2">
                    <button onclick="voteQuestion('up')" class="vote-btn-up px-4 py-2 text-gray-700 hover:bg-orange-50 border border-gray-300 rounded transition" data-type="up">
                        👍 <span class="vote-count">{{ $question->votes }}</span>
                    </button>
                    <button onclick="voteQuestion('down')" class="vote-btn-down px-4 py-2 text-gray-700 hover:bg-red-50 border border-gray-300 rounded transition" data-type="down">
                        👎
                    </button>
                </div>

                <!-- Bookmark Button -->
                <button onclick="toggleBookmark()" class="bookmark-btn px-4 py-2 text-gray-700 hover:bg-yellow-50 border border-gray-300 rounded transition {{ auth()->check() && $question->isBookmarkedBy(auth()->id()) ? 'bg-yellow-50 text-yellow-600' : '' }}">
                    {{ auth()->check() && $question->isBookmarkedBy(auth()->id()) ? '⭐ Bookmarked' : '☆ Bookmark' }}
                </button>

                <!-- Share Button -->
                <div class="ml-auto flex gap-2">
                    <button onclick="toggleShareMenu()" class="px-4 py-2 text-gray-700 hover:bg-gray-100 border border-gray-300 rounded transition">
                        📤 Share
                    </button>
                </div>
                @else
                <div class="text-sm text-gray-600">
                    <a href="{{ route('noccea.learn.login') }}" class="text-orange-600 hover:underline">Sign in</a> to vote and bookmark
                </div>
                @endauth

                <!-- Delete Button (Owner Only) -->
                @if(auth()->check() && (auth()->id() === $question->user_id || auth()->user()->is_admin ?? false))
                <form action="{{ route('noccea.learn.qa-forum.destroy', $question) }}" method="POST" class="ml-auto">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Delete this question?')" class="px-4 py-2 text-red-600 hover:bg-red-50 rounded transition border border-red-300">
                        Delete
                    </button>
                </form>
                @endif
            </div>

            <!-- Share Menu (Hidden by default) -->
            <div id="shareMenu" class="hidden mt-4 p-4 bg-gray-50 rounded border border-gray-200">
                <p class="text-sm font-semibold text-gray-700 mb-3">Share this question:</p>
                <div class="flex flex-wrap gap-3">
                    <a href="https://twitter.com/intent/tweet?text={{ urlencode($question->title) }}&url={{ route('noccea.learn.qa-forum.show', $question->slug) }}" target="_blank" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition text-sm">
                        Twitter
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ route('noccea.learn.qa-forum.show', $question->slug) }}" target="_blank" class="px-4 py-2 bg-blue-700 text-white rounded hover:bg-blue-800 transition text-sm">
                        Facebook
                    </a>
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ route('noccea.learn.qa-forum.show', $question->slug) }}" target="_blank" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition text-sm">
                        LinkedIn
                    </a>
                    <button onclick="copyLink()" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 transition text-sm">
                        Copy Link
                    </button>
                </div>
            </div>
        </div>

        <!-- Answers -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ $question->answers->count() }} Answer{{ $question->answers->count() !== 1 ? 's' : '' }}</h2>

            @forelse($question->answers as $answer)
            <div class="bg-white rounded-lg shadow-lg p-8 mb-6 border-l-4 {{ $answer->is_accepted ? 'border-green-500' : 'border-gray-200' }}">
                @if($answer->is_accepted)
                <div class="mb-4 flex items-center gap-2 text-green-700 font-semibold">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    Accepted Answer
                </div>
                @endif

                <!-- Answer Body -->
                <div class="prose max-w-none mb-6">
                    {!! nl2br(e($answer->body)) !!}
                </div>

                <!-- Answer Meta -->
                <div class="flex items-center gap-4 text-sm text-gray-600 pb-6 border-b border-gray-200">
                    <span>Answered by <strong>{{ $answer->user->name ?? 'Anonymous' }}</strong></span>
                    <span>•</span>
                    <span>{{ $answer->created_at->format('M d, Y H:i') }}</span>
                </div>

                <!-- Answer Actions -->
                <div class="flex flex-wrap gap-3 mt-6">
                    @auth
                    <div class="flex gap-2">
                        <button onclick="voteAnswer({{ $answer->id }}, 'up')" class="answer-vote-btn-up-{{ $answer->id }} px-4 py-2 text-gray-700 hover:bg-orange-50 border border-gray-300 rounded transition" data-answer-id="{{ $answer->id }}" data-type="up">
                            👍 <span class="answer-vote-count-{{ $answer->id }}">{{ $answer->votes }}</span>
                        </button>
                        <button onclick="voteAnswer({{ $answer->id }}, 'down')" class="answer-vote-btn-down-{{ $answer->id }} px-4 py-2 text-gray-700 hover:bg-red-50 border border-gray-300 rounded transition" data-answer-id="{{ $answer->id }}" data-type="down">
                            👎
                        </button>
                    </div>
                    @else
                    <div class="text-sm text-gray-600">
                        <a href="{{ route('noccea.learn.login') }}" class="text-orange-600 hover:underline">Sign in</a> to vote
                    </div>
                    @endauth

                    @if(auth()->check() && auth()->id() === $question->user_id && !$answer->is_accepted)
                    <form action="{{ route('noccea.learn.qa-forum.answer.accept', [$question, $answer]) }}" method="POST" class="ml-auto">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-green-100 text-green-700 hover:bg-green-200 rounded transition font-medium">
                            ✓ Mark as Accepted
                        </button>
                    </form>
                    @endif

                    <!-- Edit/Delete buttons for owner and admin -->
                    @if(auth()->check() && (auth()->id() === $answer->user_id || auth()->user()->is_admin ?? false))
                    <div class="flex gap-2 ml-auto">
                        <a href="{{ route('noccea.learn.qa-forum.answer.edit', [$question, $answer]) }}" class="px-4 py-2 bg-blue-100 text-blue-700 hover:bg-blue-200 rounded transition font-medium">
                            ✏️ Edit
                        </a>
                        <form action="{{ route('noccea.learn.qa-forum.answer.delete', [$question, $answer]) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Delete this answer?')" class="px-4 py-2 bg-red-100 text-red-700 hover:bg-red-200 rounded transition font-medium">
                                🗑️ Delete
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
            @empty
            <div class="bg-white rounded-lg shadow-lg p-8 text-center text-gray-500">
                <p>No answers yet. Be the first to help!</p>
            </div>
            @endforelse
        </div>

        <!-- Post Answer -->
        @auth
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Post Your Answer</h2>

            <form action="{{ route('noccea.learn.qa-forum.answer.store', $question) }}" method="POST">
                @csrf

                <div class="mb-6">
                    <label for="body" class="block text-sm font-semibold text-gray-900 mb-2">
                        Your Answer
                    </label>
                    <textarea id="body" name="body" rows="8"
                              placeholder="Write your answer here. Include details and examples to help others understand..."
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 @error('body') border-red-500 @enderror"
                              required>{{ old('body') }}</textarea>
                    @error('body')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="px-8 py-3 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition font-semibold">
                    Post Answer
                </button>
            </form>
        </div>
        @else
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-8 text-center">
            <p class="text-blue-900 mb-4">Sign in to post an answer and help the community</p>
            <a href="{{ route('noccea.learn.login') }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                Sign In
            </a>
        </div>
        @endauth
    </div>
</div>

<!-- JavaScript for interactivity -->
<script>
function voteQuestion(type) {
    fetch('{{ route("noccea.learn.qa-forum.vote", $question->slug) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ type: type })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.querySelector('.vote-count').textContent = data.votes;
            // Highlight current vote
            document.querySelector('.vote-btn-up').style.backgroundColor = data.userVote === 1 ? '#fff7ed' : '';
            document.querySelector('.vote-btn-down').style.backgroundColor = data.userVote === -1 ? '#fef2f2' : '';
        }
    })
    .catch(error => console.error('Error:', error));
}

function voteAnswer(answerId, type) {
    fetch('{{ route("noccea.learn.qa-forum.answer.vote", [$question->slug, ":answerId"]) }}'.replace(':answerId', answerId), {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ type: type })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.querySelector(`.answer-vote-count-${answerId}`).textContent = data.votes;
            // Highlight current vote
            document.querySelector(`.answer-vote-btn-up-${answerId}`).style.backgroundColor = data.userVote === 1 ? '#fff7ed' : '';
            document.querySelector(`.answer-vote-btn-down-${answerId}`).style.backgroundColor = data.userVote === -1 ? '#fef2f2' : '';
        }
    })
    .catch(error => console.error('Error:', error));
}

function toggleBookmark() {
    fetch('{{ route("noccea.learn.qa-forum.bookmark", $question->slug) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const btn = document.querySelector('.bookmark-btn');
            if (data.isBookmarked) {
                btn.textContent = '⭐ Bookmarked';
                btn.classList.add('bg-yellow-50', 'text-yellow-600');
            } else {
                btn.textContent = '☆ Bookmark';
                btn.classList.remove('bg-yellow-50', 'text-yellow-600');
            }
        }
    })
    .catch(error => console.error('Error:', error));
}

function toggleShareMenu() {
    const menu = document.getElementById('shareMenu');
    menu.classList.toggle('hidden');
}

function copyLink() {
    const link = '{{ route("noccea.learn.qa-forum.show", $question->slug) }}';
    navigator.clipboard.writeText(link).then(() => {
        alert('Link copied to clipboard!');
    }).catch(err => {
        console.error('Failed to copy:', err);
    });
}

// Close share menu when clicking outside
document.addEventListener('click', function(event) {
    const shareMenu = document.getElementById('shareMenu');
    const shareBtn = event.target.closest('button[onclick*="toggleShareMenu"]');
    if (!shareMenu.classList.contains('hidden') && !shareBtn && !event.target.closest('#shareMenu')) {
        shareMenu.classList.add('hidden');
    }
});
</script>
@endsection
