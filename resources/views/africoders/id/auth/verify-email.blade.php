@extends('africoders.id.layouts.app')

@section('title', 'Verify Email')

@section('content')
<div style="max-width: 500px; margin: 3rem auto;">
    <div class="card">
        <h1 style="margin-bottom: 1rem;">Email Verification</h1>

        @if (!auth()->user()->hasVerifiedEmail())
            <div class="alert alert-warning">
                <strong>Important:</strong> Please verify your email address to complete your registration.
            </div>

            <p style="margin-bottom: 1rem;">
                We've sent a verification link to <strong>{{ auth()->user()->email }}</strong>.
                Click the link in your email to verify your account.
            </p>

            <form action="{{ route('id.resend-verification') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary" style="width: 100%;">
                    Resend Verification Email
                </button>
            </form>
        @else
            <div class="alert alert-success">
                <strong>✓ Email Verified</strong> Your email address has been verified successfully.
            </div>

            <a href="{{ route('id.dashboard') }}" class="btn btn-primary" style="width: 100%; text-align: center;">
                Go to Dashboard
            </a>
        @endif
    </div>
</div>
@endsection
