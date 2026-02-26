@extends('noccea.learn.layout')

@section('title', $lesson->title . ' - ' . $course->title)

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-3">
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <!-- Lesson Info Header -->
                    <div class="p-8 border-b">
                        <div class="mb-4">
                            <a href="{{ route('noccea.learn.courses.show', $course->slug) }}" class="text-orange-600 hover:text-orange-700 font-semibold mb-2 inline-block">
                                ← Back to {{ $course->title }}
                            </a>
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $lesson->title }}</h1>
                            <p class="text-gray-600">Module: {{ $module->title }}</p>
                        </div>
                    </div>

                    <!-- Slides Display Area -->
                    <div class="relative bg-gradient-to-br from-gray-50 to-gray-100">
                        <div id="slidesContainer" class="min-h-[500px] p-12">
                            <!-- Slides will be dynamically displayed here -->
                        </div>

                        <!-- Slide Navigation -->
                        <div class="absolute bottom-6 left-0 right-0 flex items-center justify-between px-8">
                            <button onclick="previousSlide()" id="prevBtn" class="flex items-center gap-2 px-6 py-3 bg-white text-gray-700 rounded-lg hover:bg-gray-100 shadow-lg transition disabled:opacity-50 disabled:cursor-not-allowed">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                                Previous
                            </button>

                            <div class="flex gap-2" id="slideIndicators">
                                <!-- Slide indicators will be added here -->
                            </div>

                            <button onclick="nextSlide()" id="nextBtn" class="flex items-center gap-2 px-6 py-3 bg-orange-600 text-white rounded-lg hover:bg-orange-700 shadow-lg transition">
                                Next
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Actions Below Slides -->
                    <div class="p-8">

                        <!-- Completion Button -->
                        @auth
                        <div class="flex gap-4">
                            <button onclick="markComplete({{ $lesson->id }})" id="completeBtn" class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold">
                                @if($lesson->isCompletedBy(auth()->id()))
                                    ✓ Marked Complete
                                @else
                                    Mark as Complete
                                @endif
                            </button>
                            <a href="{{ route('noccea.learn.courses.show', $course->slug) }}" class="px-6 py-3 bg-gray-200 text-gray-900 rounded-lg hover:bg-gray-300 transition font-semibold">
                                Exit Lesson
                            </a>
                        </div>
                        @else
                        <a href="{{ route('noccea.learn.login') }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                            Sign in to Mark Complete
                        </a>
                        @endauth
                    </div>
                </div>
            </div>

            <!-- Sidebar - Course Progress -->
            <div class="lg:col-span-1">
                <!-- Course Card -->
                <div class="bg-white rounded-lg shadow-lg p-6 sticky top-20">
                    <h3 class="font-bold text-gray-900 mb-4">{{ $course->title }}</h3>

                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-2">
                            <p class="text-sm font-semibold text-gray-700">Course Progress</p>
                            @php
                                $enrollment = $course->enrollments()
                                    ->where('user_id', auth()->id() ?? 0)
                                    ->first();
                            @endphp
                            <p class="text-sm font-bold text-orange-600">{{ $enrollment?->progress_percentage ?? 0 }}%</p>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-orange-600 h-2 rounded-full transition-all duration-300"
                                 style="width: {{ $enrollment?->progress_percentage ?? 0 }}%"></div>
                        </div>
                    </div>

                    <!-- Modules & Lessons -->
                    <div class="space-y-2">
                        @foreach($module->course->modules()->orderBy('order')->with('lessons')->get() as $mod)
                        <div class="border-t pt-2 mt-2">
                            <p class="text-xs font-semibold text-gray-600 uppercase mb-2">{{ $mod->title }}</p>
                            <div class="space-y-1">
                                @foreach($mod->lessons as $les)
                                <a href="{{ route('noccea.learn.lesson.show', [$course->slug, $mod->title, $les->id]) }}"
                                   class="block text-xs p-2 rounded transition
                                   @if($les->id == $lesson->id)
                                       bg-orange-100 text-orange-900 font-semibold
                                   @elseif($les->isCompletedBy(auth()->id() ?? 0))
                                       bg-green-50 text-green-900
                                   @else
                                       bg-gray-50 hover:bg-gray-100 text-gray-700
                                   @endif">
                                    @if($les->isCompletedBy(auth()->id() ?? 0))
                                        <span class="inline-block w-4 h-4 bg-green-500 text-white rounded text-center text-xs">✓</span>
                                    @else
                                        <span class="inline-block w-4 h-4 bg-gray-300 text-white rounded text-center text-xs">•</span>
                                    @endif
                                    {{ $les->title }}
                                </a>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.slide-content {
    animation: slideIn 0.3s ease-out;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.slide-title {
    font-size: 2rem;
    font-weight: 700;
    color: #1a202c;
    margin-bottom: 1.5rem;
}

.slide-text {
    font-size: 1.125rem;
    line-height: 1.75;
    color: #4a5568;
    margin-bottom: 1rem;
}

.slide-list {
    list-style-type: disc;
    margin-left: 2rem;
    margin-bottom: 1.5rem;
}

.slide-list li {
    font-size: 1.125rem;
    line-height: 1.75;
    color: #4a5568;
    margin-bottom: 0.75rem;
}

.code-example {
    background-color: #2d3748;
    color: #e2e8f0;
    padding: 1.5rem;
    border-radius: 0.5rem;
    font-family: 'Courier New', monospace;
    font-size: 0.95rem;
    overflow-x: auto;
    margin: 1.5rem 0;
}

.code-example pre {
    margin: 0;
    white-space: pre-wrap;
    word-wrap: break-word;
}

.tips-box {
    background-color: #fef3c7;
    border-left: 4px solid #f59e0b;
    padding: 1rem 1.5rem;
    border-radius: 0.375rem;
    margin: 1.5rem 0;
}
</style>

<script>
const lessonContent = {!! json_encode($lesson->content) !!};
let currentSlide = 0;
let slides = [];

// Parse slides from content
function parseSlides() {
    const parser = new DOMParser();
    const doc = parser.parseFromString(lessonContent, 'text/html');
    const slideElements = doc.querySelectorAll('.slide');
    slides = Array.from(slideElements).map(slide => slide.innerHTML);
    return slides.length;
}

function displaySlide(index) {
    const container = document.getElementById('slidesContainer');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');

    if (index < 0 || index >= slides.length) return;

    container.innerHTML = `<div class="slide-content">${slides[index]}</div>`;
    currentSlide = index;

    // Update button states
    prevBtn.disabled = index === 0;
    nextBtn.textContent = index === slides.length - 1 ? 'Complete Lesson' : 'Next';

    // Update indicators
    updateIndicators();
}

function updateIndicators() {
    const indicators = document.getElementById('slideIndicators');
    indicators.innerHTML = slides.map((_, idx) =>
        `<div class="w-2 h-2 rounded-full transition ${idx === currentSlide ? 'bg-orange-600 w-8' : 'bg-gray-300'} cursor-pointer" onclick="displaySlide(${idx})"></div>`
    ).join('');
}

function previousSlide() {
    if (currentSlide > 0) {
        displaySlide(currentSlide - 1);
    }
}

function nextSlide() {
    if (currentSlide < slides.length - 1) {
        displaySlide(currentSlide + 1);
    } else {
        // On last slide, mark as complete
        markComplete({{ $lesson->id }});
    }
}

function markComplete(lessonId) {
    fetch(`{{ route('noccea.learn.lesson.complete', ':lessonId') }}`.replace(':lessonId', lessonId), {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            const btn = document.getElementById('completeBtn');
            if (btn) {
                btn.textContent = '✓ Marked Complete';
                btn.disabled = true;
                btn.classList.add('opacity-50', 'cursor-not-allowed');
            }

            // Update progress bar
            const progressBar = document.querySelector('[style*="width:"]');
            if (progressBar) {
                progressBar.style.width = data.progress + '%';
            }

            // Navigate to next lesson or show completion message
            if (data.nextLessonUrl) {
                setTimeout(() => {
                    if (confirm('Great job! Ready for the next lesson?')) {
                        window.location.href = data.nextLessonUrl;
                    }
                }, 500);
            } else if (data.courseCompleted) {
                setTimeout(() => {
                    alert('🎉 Congratulations! You\'ve completed the entire course!');
                    window.location.href = '{{ route("noccea.learn.dashboard") }}';
                }, 500);
            } else {
                alert('Lesson completed! Keep up the great work!');
            }
        }
    })
    .catch(error => console.error('Error:', error));
}

// Keyboard navigation
document.addEventListener('keydown', (e) => {
    if (e.key === 'ArrowLeft') previousSlide();
    if (e.key === 'ArrowRight') nextSlide();
});

// Initialize on page load
document.addEventListener('DOMContentLoaded', () => {
    const slideCount = parseSlides();
    if (slideCount > 0) {
        displaySlide(0);
    }
});
</script>
@endsection
