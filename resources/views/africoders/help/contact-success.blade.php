@extends('africoders.help.layout')

@section('title', 'Message Sent - Africoders Help')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center">
                <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                <h1 class="mt-3">Message Sent Successfully!</h1>
                <p class="lead">Thank you for contacting us. We've received your message and will get back to you as soon as possible.</p>
            </div>

            <div class="card mt-4">
                <div class="card-body text-center">
                    <h5>What happens next?</h5>
                    <ul class="list-unstyled">
                        <li><strong>1.</strong> Our team will review your message</li>
                        <li><strong>2.</strong> We'll respond via email within our standard timeframe</li>
                        <li><strong>3.</strong> Check your spam folder if you don't see our response</li>
                    </ul>

                    <div class="mt-4">
                        <a href="{{ route('help.home') }}" class="btn btn-primary">
                            <i class="bi bi-house"></i> Back to Help Center
                        </a>
                        <a href="{{ route('help.contact') }}" class="btn btn-outline-secondary ms-2">
                            <i class="bi bi-envelope"></i> Send Another Message
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
