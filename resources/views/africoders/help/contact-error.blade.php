@extends('africoders.help.layout')

@section('title', 'Error - Africoders Help')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center">
                <i class="bi bi-exclamation-triangle-fill text-warning" style="font-size: 4rem;"></i>
                <h1 class="mt-3">Oops! Something went wrong</h1>
                <p class="lead">We encountered an error while sending your message. Please try again.</p>
            </div>

            <div class="card mt-4">
                <div class="card-body text-center">
                    <h5>What you can do:</h5>
                    <ul class="list-unstyled">
                        <li><strong>1.</strong> Go back and try sending your message again</li>
                        <li><strong>2.</strong> Check your internet connection</li>
                        <li><strong>3.</strong> Contact us directly via email if the problem persists</li>
                    </ul>

                    <div class="mt-4">
                        <a href="{{ route('help.contact') }}" class="btn btn-primary">
                            <i class="bi bi-arrow-left"></i> Try Again
                        </a>
                        <a href="{{ route('help.home') }}" class="btn btn-outline-secondary ms-2">
                            <i class="bi bi-house"></i> Back to Help Center
                        </a>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0">Direct Contact</h5>
                </div>
                <div class="card-body">
                    <p>You can also reach us directly:</p>
                    <ul>
                        <li><strong>Support:</strong> <a href="mailto:support@africoders.com">support@africoders.com</a></li>
                        <li><strong>Business:</strong> <a href="mailto:partners@africoders.com">partners@africoders.com</a></li>
                        <li><strong>Legal:</strong> <a href="mailto:legal@africoders.com">legal@africoders.com</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
