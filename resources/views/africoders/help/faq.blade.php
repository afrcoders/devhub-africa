@extends('africoders.help.layout')

@section('title', 'Frequently Asked Questions - Africoders Help')

@section('content')
    <div class="section-header text-center">
        <h1>Frequently Asked Questions</h1>
        <p>Quick answers to common questions about Africoders</p>
    </div>

    <!-- Search within FAQ -->
    <div class="search-box">
        <form method="GET" action="{{ route('help.search') }}">
            <div class="input-group">
                <span class="input-group-text bg-white border-0">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" class="form-control border-0" name="q" placeholder="Search FAQs..." value="{{ request('q') }}">
                <input type="hidden" name="type" value="faq">
            </div>
        </form>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- General Questions -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-question-circle text-primary me-2"></i>
                        General Questions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="accordion" id="generalAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="general1">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1">
                                    What is Africoders?
                                </button>
                            </h2>
                            <div id="collapse1" class="accordion-collapse collapse" data-bs-parent="#generalAccordion">
                                <div class="accordion-body">
                                    Africoders is a comprehensive platform designed for developers, creators, and technology enthusiasts across Africa. We provide identity services, community forums, business networking, and developer resources to help build innovative solutions.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="general2">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2">
                                    How do I get started?
                                </button>
                            </h2>
                            <div id="collapse2" class="accordion-collapse collapse" data-bs-parent="#generalAccordion">
                                <div class="accordion-body">
                                    Getting started is simple! Create an account through our <a href="https://{{ config('domains.africoders.id') }}">Identity Service</a>, verify your email, and you'll have access to all our platforms and services.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="general3">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3">
                                    Is Africoders free to use?
                                </button>
                            </h2>
                            <div id="collapse3" class="accordion-collapse collapse" data-bs-parent="#generalAccordion">
                                <div class="accordion-body">
                                    Yes! Core Africoders services are free to use. This includes account creation, basic community features, and access to developer resources. Premium features may be available in the future.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Account Questions -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-person-circle text-primary me-2"></i>
                        Account & Security
                    </h5>
                </div>
                <div class="card-body">
                    <div class="accordion" id="accountAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="account1">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accountCollapse1">
                                    How do I reset my password?
                                </button>
                            </h2>
                            <div id="accountCollapse1" class="accordion-collapse collapse" data-bs-parent="#accountAccordion">
                                <div class="accordion-body">
                                    Visit the <a href="https://{{ config('domains.africoders.id') }}/auth">login page</a> and click "Forgot Password." Enter your email address and we'll send you a password reset link.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="account2">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accountCollapse2">
                                    How do I update my profile information?
                                </button>
                            </h2>
                            <div id="accountCollapse2" class="accordion-collapse collapse" data-bs-parent="#accountAccordion">
                                <div class="accordion-body">
                                    Log into your account and visit your <a href="https://{{ config('domains.africoders.id') }}/profile">profile page</a>. You can update your personal information, preferences, and privacy settings there.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="account3">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accountCollapse3">
                                    How secure is my data?
                                </button>
                            </h2>
                            <div id="accountCollapse3" class="accordion-collapse collapse" data-bs-parent="#accountAccordion">
                                <div class="accordion-body">
                                    We take security seriously. Your data is encrypted, stored securely, and we follow industry best practices. Read our <a href="{{ route('help.legal', 'privacy') }}">Privacy Policy</a> for detailed information about how we protect your data.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Technical Questions -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-gear text-primary me-2"></i>
                        Technical Support
                    </h5>
                </div>
                <div class="card-body">
                    <div class="accordion" id="techAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="tech1">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#techCollapse1">
                                    I'm having trouble logging in. What should I do?
                                </button>
                            </h2>
                            <div id="techCollapse1" class="accordion-collapse collapse" data-bs-parent="#techAccordion">
                                <div class="accordion-body">
                                    First, ensure you're using the correct email and password. Try clearing your browser cache and cookies. If you still can't log in, use the password reset option or <a href="{{ route('help.contact') }}">contact our support team</a>.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="tech2">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#techCollapse2">
                                    The website isn't loading properly. How can I fix this?
                                </button>
                            </h2>
                            <div id="techCollapse2" class="accordion-collapse collapse" data-bs-parent="#techAccordion">
                                <div class="accordion-body">
                                    Try refreshing the page, clearing your browser cache, or using a different browser. If the problem persists, it might be a temporary issue on our end. Check our status page or contact support if the issue continues.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Didn't Find Your Answer?</h5>
                </div>
                <div class="card-body">
                    <p>If you can't find what you're looking for in our FAQs, try these options:</p>
                    <div class="d-grid gap-2">
                        <a href="{{ route('help.search') }}" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-search"></i> Search Help Articles
                        </a>
                        <a href="{{ route('help.contact') }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-envelope"></i> Contact Support
                        </a>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Popular Help Articles</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li><a href="{{ route('help.article', 'getting-started') }}">Getting Started Guide</a></li>
                        <li><a href="{{ route('help.article', 'account-security') }}">Account Security</a></li>
                        <li><a href="{{ route('help.article', 'privacy-settings') }}">Privacy Settings</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
