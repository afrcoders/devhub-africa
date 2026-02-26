@extends('noccea.community.layout')

@push('head')
<!-- Summernote CSS -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<style>
/* Ensure Summernote editor takes full width */
.note-editor {
    width: 100% !important;
    border: 1px solid #d1d5db;
    border-radius: 0.5rem;
}
.note-editor .note-editing-area {
    width: 100% !important;
}
.note-editor .note-editable {
    width: 100% !important;
    min-width: 100% !important;
    padding: 1rem;
    min-height: 300px;
}
.note-toolbar {
    background-color: #f9fafb;
    border-bottom: 1px solid #d1d5db;
    border-radius: 0.5rem 0.5rem 0 0;
}
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Header -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="p-6 border-b border-gray-200">
                <!-- Breadcrumb -->
                <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
                    <a href="{{ route('noccea.community.home') }}" class="hover:text-gray-700">Community</a>
                    <span>/</span>
                    <a href="{{ route('noccea.community.discussions.index') }}" class="hover:text-gray-700">Discussions</a>
                    <span>/</span>
                    <a href="{{ route('noccea.community.discussions.show', $discussion) }}" class="hover:text-gray-700">{{ Str::limit($discussion->title, 50) }}</a>
                    <span>/</span>
                    <span class="text-gray-900">Edit Reply</span>
                </div>

                <!-- Page Title -->
                <div class="flex items-center gap-3">
                    <div class="flex-1">
                        <h1 class="text-2xl font-bold text-gray-900">Edit Your Reply</h1>
                        <p class="text-gray-600 mt-1">Update your reply to "{{ $discussion->title }}"</p>
                    </div>
                </div>
            </div>

            <!-- Original Discussion Preview -->
            <div class="p-6 border-b border-gray-200 bg-gray-50">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center text-white font-semibold">
                        {{ strtoupper(substr($discussion->user->username, 0, 1)) }}
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-2">
                            <p class="font-medium text-gray-900">{{ $discussion->user->full_name ?: $discussion->user->username }}</p>
                            <span class="text-gray-400">•</span>
                            <p class="text-sm text-gray-500">{{ $discussion->created_at->format('M j, Y \a\t g:i A') }}</p>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">{{ $discussion->title }}</h3>
                        <div class="prose prose-sm max-w-none text-gray-700">
                            {!! Str::limit(strip_tags($discussion->body), 200) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Reply Form -->
        <div class="bg-white rounded-lg shadow">
            <form action="{{ route('noccea.community.replies.update', $reply) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="p-6">
                    <!-- Original Reply Info -->
                    <div class="bg-gray-50 rounded-lg p-4 mb-6">
                        <div class="flex items-center gap-2 mb-2">
                            <p class="text-sm font-medium text-gray-900">Originally posted by you</p>
                            <span class="text-gray-400">•</span>
                            <p class="text-sm text-gray-500">{{ $reply->created_at->format('M j, Y \a\t g:i A') }}</p>
                            @if($reply->updated_at != $reply->created_at)
                                <span class="text-gray-400">•</span>
                                <p class="text-sm text-gray-500">Last edited: {{ $reply->updated_at->format('M j, Y \a\t g:i A') }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="reply-body" class="block text-sm font-medium text-gray-700 mb-2">
                            Edit Your Reply *
                        </label>
                        <textarea name="body" id="reply-body" required
                                  placeholder="Update your thoughts, insights, or questions..."
                                  class="summernote-reply">{{ old('body', $reply->body) }}</textarea>
                        @error('body')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Guidelines -->
                    <div class="bg-blue-50 rounded-lg p-4 mb-6">
                        <h4 class="font-medium text-blue-900 mb-2">Editing Guidelines</h4>
                        <ul class="text-sm text-blue-800 space-y-1">
                            <li>• Keep your edits respectful and constructive</li>
                            <li>• Major changes should be clearly explained</li>
                            <li>• Consider the context of existing responses</li>
                            <li>• Maintain the original intent where possible</li>
                        </ul>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                        <div class="flex items-center gap-4">
                            <a href="{{ route('noccea.community.discussions.show', $discussion) }}"
                               class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                                Cancel
                            </a>
                            <p class="text-sm text-gray-500">
                                This reply will be marked as edited
                            </p>
                        </div>
                        <button type="submit"
                                class="px-6 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition focus:ring-2 focus:ring-blue-500">
                            Update Reply
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- jQuery (required for Summernote) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Summernote JS -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize Summernote for reply editing
    $('.summernote-reply').summernote({
        height: 350,
        minHeight: 250,
        maxHeight: 600,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ],
        placeholder: 'Update your thoughts, insights, or questions...',
        dialogsInBody: true,
        disableDragAndDrop: false,
        callbacks: {
            onImageUpload: function(files) {
                // Handle image upload - for now, disable it
                alert('Direct image uploads are not supported. Please use image URLs or external hosting services.');
                return false;
            },
            onInit: function() {
                console.log('Edit Reply Summernote initialized');
                // Ensure editor is focused for better UX
                $(this).summernote('focus');
            },
            onFocus: function() {
                // Add focused styling
                $('.note-editor').addClass('ring-2 ring-blue-500');
            },
            onBlur: function() {
                // Remove focused styling
                $('.note-editor').removeClass('ring-2 ring-blue-500');
            }
        }
    });

    // Form submission validation
    $('form').on('submit', function(e) {
        const summernoteContent = $('.summernote-reply').summernote('code');
        const textContent = $('<div>').html(summernoteContent).text().trim();

        if (textContent.length < 10) {
            e.preventDefault();
            alert('Please provide a more detailed reply (at least 10 characters).');
            $('.summernote-reply').summernote('focus');
            return false;
        }

        // Show loading state
        const submitButton = $(this).find('button[type="submit"]');
        submitButton.prop('disabled', true).text('Updating Reply...');
    });

    // Warn about unsaved changes
    let originalContent = $('.summernote-reply').summernote('code');

    $(window).on('beforeunload', function() {
        const currentContent = $('.summernote-reply').summernote('code');
        if (currentContent !== originalContent) {
            return 'You have unsaved changes. Are you sure you want to leave?';
        }
    });

    // Remove warning when form is submitted
    $('form').on('submit', function() {
        $(window).off('beforeunload');
    });
});
</script>
@endpush
