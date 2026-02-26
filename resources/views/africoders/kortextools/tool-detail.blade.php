@extends('africoders.kortextools.layout')

@section('title', $tool->name . ' - KortexTools')

@section('meta_description', $tool->description ?? $tool->name . ' - Free online tool')

@section('content')
<div class="container-lg py-5">
    <div class="row">
        <!-- Tool Detail -->
        <div class="col-lg-8">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="https://{{ config('domains.tools.kortex') }}/">Home</a></li>
                    <li class="breadcrumb-item"><a href="https://{{ config('domains.tools.kortex') }}/tools/{{ \Illuminate\Support\Str::slug($tool->category) }}">{{ ucfirst($tool->category) }}</a></li>
                    <li class="breadcrumb-item active">{{ $tool->name }}</li>
                </ol>
            </nav>

            <!-- Tool Header -->
            <div class="mb-5">
                <div class="d-flex align-items-center mb-3">
                    <i class="{{ $tool->icon ?? 'bi bi-tools' }} tool-icon"></i>
                    <div class="ms-3">
                        <h1 class="h2 mb-1">{{ $tool->name }}</h1>
                        <div class="text-muted">
                            <small>
                                <span class="category-badge">{{ ucfirst($tool->category) }}</span>
                                @if(isset($tool->rating))
                                    <span class="ms-2">
                                        <i class="bi bi-star-fill text-warning"></i>
                                        {{ number_format($tool->rating, 1) }}
                                        ({{ $tool->rating_count ?? 0 }} ratings)
                                    </span>
                                @endif
                            </small>
                        </div>
                    </div>
                </div>
                <p class="lead text-muted">{{ $tool->description ?? 'Free online tool for developers and productivity enthusiasts.' }}</p>
            </div>

            <!-- Tool Input Form -->
            <div class="card mb-5">
                <div class="card-header">
                    <h5 class="mb-0">{{ $tool->name}}</h5>
                </div>
                <div class="card-body">
                    @includeFirst([
                        'africoders.kortextools.tools.' . $tool->slug,
                        'africoders.kortextools.tools.placeholder'
                    ], compact('tool'))
                </div>
            </div>

            <!-- Tool Rating -->
            <div class="card mb-4">
                <div class="card-body">
                    <h6 class="card-title">Was this tool helpful?</h6>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-success rate-btn" data-rating="1">
                            <i class="bi bi-hand-thumbs-up"></i> Yes
                        </button>
                        <button type="button" class="btn btn-outline-danger rate-btn" data-rating="0">
                            <i class="bi bi-hand-thumbs-down"></i> No
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Info Card -->
            <div class="card mb-4">
                <div class="card-body">
                    <h6 class="card-title">Tool Information</h6>
                    <div class="mb-3">
                        <small class="text-muted d-block">Category</small>
                        <a href="https://{{ config('domains.tools.kortex') }}/tools/{{ $tool->category }}" class="text-decoration-none">
                            {{ ucfirst($tool->category) }}
                        </a>
                    </div>
                    @if(isset($tool->created_at))
                    <div>
                        <small class="text-muted d-block">Added</small>
                        <span>{{ \Carbon\Carbon::parse($tool->created_at)->format('M d, Y') }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Related Tools -->
            @if(isset($relatedTools) && count($relatedTools) > 0)
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Related Tools</h6>
                    <div class="list-group list-group-flush">
                        @foreach($relatedTools as $relatedTool)
                        <a href="https://{{ config('domains.tools.kortex') }}/tool/{{ $relatedTool['slug'] }}" class="list-group-item list-group-item-action px-0 py-2">
                            <small class="text-muted d-block">{{ $relatedTool['name'] }}</small>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const rateButtons = document.querySelectorAll('.rate-btn');
    rateButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const rating = this.dataset.rating;
            const slug = '{{ $tool->slug }}';

            fetch(`/api/tools/${slug}/rate`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify({ rating: parseInt(rating) })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Thank you for your feedback!');
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
});
</script>
@endsection
