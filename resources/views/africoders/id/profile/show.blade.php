@extends('africoders.id.layouts.app')

@section('title', 'Profile')

@section('content')
<div style="max-width: 800px;">
    <h1 style="margin-bottom: 2rem;">Profile</h1>

    @if (session('password_success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> {{ session('password_success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle"></i>
            {{ $errors->first() ?? 'An error occurred.' }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <h2 style="margin-bottom: 1.5rem;">Account Information</h2>

        <div style="display: grid; gap: 1rem;">
            <div>
                <p style="color: var(--gray-700); font-size: 0.875rem; margin-bottom: 0.25rem;">Full Name</p>
                <p><strong>{{ $user->full_name }}</strong></p>
            </div>

            <div>
                <p style="color: var(--gray-700); font-size: 0.875rem; margin-bottom: 0.25rem;">Username</p>
                <p><strong>{{ $user->username }}</strong></p>
            </div>

            <div>
                <p style="color: var(--gray-700); font-size: 0.875rem; margin-bottom: 0.25rem;">Email</p>
                <p>
                    <strong>{{ $user->email }}</strong>
                    @if ($user->hasVerifiedEmail())
                        <span style="color: var(--success); margin-left: 0.5rem;">✓ Verified</span>
                    @else
                        <span style="color: var(--warning); margin-left: 0.5rem;">⚠ Not Verified</span>
                    @endif
                </p>
            </div>

            <div>
                <p style="color: var(--gray-700); font-size: 0.875rem; margin-bottom: 0.25rem;">Phone</p>
                <p>{{ $user->phone ?? 'Not provided' }}</p>
            </div>

            <div>
                <p style="color: var(--gray-700); font-size: 0.875rem; margin-bottom: 0.25rem;">Country</p>
                <p>{{ $user->country ?? 'Not provided' }}</p>
            </div>

            <div>
                <p style="color: var(--gray-700); font-size: 0.875rem; margin-bottom: 0.25rem;">Role</p>
                <p><strong>{{ ucfirst($user->role) }}</strong></p>
            </div>

            <div>
                <p style="color: var(--gray-700); font-size: 0.875rem; margin-bottom: 0.25rem;">Trust Level</p>
                <p><strong>{{ ucfirst($user->trust_level) }}</strong></p>
            </div>

            <div>
                <p style="color: var(--gray-700); font-size: 0.875rem; margin-bottom: 0.25rem;">Member Since</p>
                <p>{{ $user->created_at->format('M d, Y') }}</p>
            </div>
        </div>

        <hr style="margin: 2rem 0;">

        <a href="{{ route('id.profile.edit') }}" class="btn btn-primary" style="margin-right: 0.5rem;">
            Edit Profile
        </a>
        <a href="{{ route('id.change-password') }}" class="btn btn-primary">
            Change Password
        </a>
    </div>
</div>
@endsection
