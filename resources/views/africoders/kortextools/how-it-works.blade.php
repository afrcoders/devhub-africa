@extends('africoders.kortextools.layout')

@section('title', 'How KortexTools Works - KortexTools')
@section('meta_description', 'Learn how to use KortexTools to boost your productivity')

@section('content')
<div class="kortextools-how-it-works">
    <!-- Hero -->
    <section class="hero bg-primary text-white py-5">
        <div class="container text-center">
            <h1 class="display-5 fw-bold mb-3">How KortexTools Works</h1>
            <p class="lead">Simple. Fast. No signup required.</p>
        </div>
    </section>

    <!-- Content -->
    <div class="container my-5">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <!-- Step 1 -->
                <div class="step mb-5">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h2 class="h3 mb-3">
                                <span class="badge bg-primary me-2">1</span>
                                Choose Your Tool
                            </h2>
                            <p class="text-muted">Browse our extensive library of 100+ free tools across multiple categories. Use search or browse by category to find exactly what you need.</p>
                        </div>
                        <div class="col-md-6">
                            <div class="bg-light p-4 rounded text-center">
                                <i class="fas fa-toolbox fa-4x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-5">

                <!-- Step 2 -->
                <div class="step mb-5">
                    <div class="row align-items-center">
                        <div class="col-md-6 order-md-2">
                            <h2 class="h3 mb-3">
                                <span class="badge bg-primary me-2">2</span>
                                Input Your Data
                            </h2>
                            <p class="text-muted">Paste your text, upload a file, or enter the information you want to process. No signup, login, or registration required.</p>
                        </div>
                        <div class="col-md-6 order-md-1">
                            <div class="bg-light p-4 rounded text-center">
                                <i class="fas fa-arrow-down fa-4x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-5">

                <!-- Step 3 -->
                <div class="step mb-5">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h2 class="h3 mb-3">
                                <span class="badge bg-primary me-2">3</span>
                                Get Instant Results
                            </h2>
                            <p class="text-muted">Your results are processed instantly in your browser. Download, copy, or share your output with a single click.</p>
                        </div>
                        <div class="col-md-6">
                            <div class="bg-light p-4 rounded text-center">
                                <i class="fas fa-download fa-4x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-5">

                <!-- Why Choose -->
                <section class="why-choose">
                    <h2 class="h3 mb-4 text-center">Why Choose KortexTools?</h2>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="feature">
                                <h5 class="mb-2">
                                    <i class="fas fa-lock text-primary me-2"></i>
                                    100% Private
                                </h5>
                                <p class="text-muted">Your data never leaves your browser. We don't store or log any of your information.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="feature">
                                <h5 class="mb-2">
                                    <i class="fas fa-bolt text-primary me-2"></i>
                                    Lightning Fast
                                </h5>
                                <p class="text-muted">All processing happens instantly in your browser. No waiting, no delays.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="feature">
                                <h5 class="mb-2">
                                    <i class="fas fa-infinity text-primary me-2"></i>
                                    Completely Free
                                </h5>
                                <p class="text-muted">No ads, no premium tiers, no hidden fees. All tools are free forever.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="feature">
                                <h5 class="mb-2">
                                    <i class="fas fa-mobile-alt text-primary me-2"></i>
                                    Works Everywhere
                                </h5>
                                <p class="text-muted">Mobile, tablet, or desktop. Works on any device with a modern browser.</p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- CTA -->
                <div class="text-center my-5">
                    <h3 class="mb-3">Ready to Get Started?</h3>
                    <a href="{{ route('tools.kortex.tools.index') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-tools"></i> Browse All Tools
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.step {
    background: #f8f9fa;
    padding: 2rem;
    border-radius: 10px;
}

.feature {
    padding: 1.5rem;
    background: #f8f9fa;
    border-radius: 8px;
}
</style>
@endsection
