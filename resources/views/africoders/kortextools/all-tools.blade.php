@extends('africoders.kortextools.layout')

@section('title', $metaTitle ?? 'All Tools A-Z - KortexTools')
@section('description', $metaDescription ?? 'Browse our complete collection of online tools organized by category from A to Z.')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="text-center">
                <h1 class="display-4 fw-bold mb-3">
                    <i class="bi bi-list-ul me-3"></i>All Tools Directory
                </h1>
                <p class="lead text-muted mb-4">
                    Complete collection of {{ number_format($totalTools) }} tools organized by category
                </p>
                <div class="badge bg-primary fs-6 mb-4">
                    {{ count($toolsByCategory) }} Categories • {{ number_format($totalTools) }} Tools
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Navigation -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">
                        <i class="bi bi-bookmark-star me-2"></i>Quick Navigation
                    </h5>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($toolsByCategory->keys() as $category)
                            <a href="#category-{{ \Illuminate\Support\Str::slug($category) }}"
                               class="btn btn-outline-primary btn-sm">
                                {{ $category }} ({{ count($toolsByCategory[$category]) }})
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tools by Category -->
    @foreach($toolsByCategory as $categoryName => $tools)
        <div class="row mb-5" id="category-{{ \Illuminate\Support\Str::slug($categoryName) }}">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-gradient text-white"
                         style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <h3 class="mb-0">
                            <i class="bi bi-folder me-2"></i>
                            {{ $categoryName }}
                            <span class="badge bg-light text-dark ms-2">{{ count($tools) }} tools</span>
                        </h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="row g-0">
                            @foreach($tools->chunk(3) as $toolChunk)
                                @foreach($toolChunk as $index => $tool)
                                    <div class="col-lg-4 col-md-6">
                                        <div class="p-4 border-end border-bottom h-100 tool-item">
                                            <div class="d-flex align-items-start">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="tool-icon">
                                                        <i class="{{ $tool->icon ?? 'bi bi-wrench' }}"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h5 class="tool-title mb-2">
                                                        <a href="{{ route('tools.kortex.tool.show', $tool->slug) }}"
                                                           class="text-decoration-none">
                                                            {{ $tool->name }}
                                                        </a>
                                                    </h5>
                                                    <p class="text-muted small mb-3">
                                                        {{ \Illuminate\Support\Str::limit($tool->description, 80) }}
                                                    </p>
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <div class="tool-stats small text-muted">
                                                            @if($tool->rating > 0)
                                                                <span class="me-2">
                                                                    <i class="bi bi-star-fill text-warning"></i>
                                                                    {{ $tool->rating }}
                                                                </span>
                                                            @endif
                                                            @if($tool->popularity > 0)
                                                                <span>
                                                                    <i class="bi bi-eye text-info"></i>
                                                                    {{ number_format($tool->popularity) }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <a href="{{ route('tools.kortex.tool.show', $tool->slug) }}"
                                                           class="btn btn-sm btn-outline-primary">
                                                            Try Now
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if(($loop->parent->index * 3 + $loop->index + 1) % 3 === 0)
                                        </div><div class="row g-0">
                                    @endif
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Back to Top -->
    <div class="text-center mt-5">
        <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})"
                class="btn btn-outline-secondary btn-lg">
            <i class="bi bi-arrow-up"></i> Back to Top
        </button>
    </div>
</div>

<style>
.tool-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
}

.tool-item {
    transition: all 0.3s ease;
    position: relative;
}

.tool-item:hover {
    background-color: #f8f9fa;
    transform: translateY(-2px);
}

.tool-title a {
    color: #2d3748;
    font-weight: 600;
    transition: color 0.2s ease;
}

.tool-title a:hover {
    color: #667eea;
}

.card-header.bg-gradient {
    border: none;
}

.badge.bg-light {
    font-size: 0.75rem;
}

@media (max-width: 768px) {
    .tool-item {
        border-right: none !important;
    }

    .tool-item:not(:last-child) {
        border-bottom: 1px solid #dee2e6;
    }
}

/* Smooth scrolling for anchor links */
html {
    scroll-behavior: smooth;
}

/* Quick navigation styling */
.quick-nav .btn-outline-primary {
    border-color: #667eea;
    color: #667eea;
}

.quick-nav .btn-outline-primary:hover {
    background-color: #667eea;
    border-color: #667eea;
}

/* Search highlight effect */
.tool-item.highlight {
    background-color: #fff3cd;
    border-color: #ffeaa7;
    animation: highlight-fade 2s ease-out;
}

@keyframes highlight-fade {
    0% { background-color: #fff3cd; }
    100% { background-color: transparent; }
}
</style>

<script>
// Smooth scrolling for navigation links
document.addEventListener('DOMContentLoaded', function() {
    // Add click handlers for category navigation
    document.querySelectorAll('a[href^="#category-"]').forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);

            if (targetElement) {
                const offsetTop = targetElement.offsetTop - 100; // Account for fixed header
                window.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });

                // Add highlight effect
                targetElement.classList.add('highlight');
                setTimeout(() => {
                    targetElement.classList.remove('highlight');
                }, 2000);
            }
        });
    });
});

// Optional: Add keyboard navigation
document.addEventListener('keydown', function(e) {
    if (e.ctrlKey && e.key === 'f') {
        // Custom search behavior could be added here
    }
});
</script>
@endsection
