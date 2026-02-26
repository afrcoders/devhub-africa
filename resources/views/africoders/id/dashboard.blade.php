@extends('africoders.id.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div>
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 2rem;">
        <h1 style="margin: 0;">Dashboard</h1>
        <a href="{{ route('id.sessions.index') }}" style="display: flex; align-items: center; gap: 0.5rem; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; padding: 0.75rem 1.5rem; border-radius: 0.5rem; text-decoration: none; font-weight: 600; box-shadow: 0 4px 6px rgba(59, 130, 246, 0.2);">
            <i class="bi bi-shield-check"></i> Active Sessions: <strong>{{ $user->getActiveSessionCount() }}</strong>
        </a>
    </div>

    @if (!$emailVerified)
        <div class="alert alert-warning">
            <strong>⚠ Email Not Verified</strong><br>
            Please verify your email address to unlock all features.
            <a href="{{ route('id.verify-email') }}" class="btn btn-primary btn-sm" style="margin-top: 0.5rem;">
                Verify Email
            </a>
        </div>
    @else
        <div class="alert alert-success">
            <strong>✓ Email Verified</strong> Your email address has been verified.
        </div>
    @endif

    <div class="card" style="margin-bottom: 2rem;">
        <h2 style="margin-bottom: 1rem;">Welcome, {{ $user->full_name }}!</h2>

        <p>Email: <strong>{{ $user->email }}</strong></p>
        <p>Username: <strong>{{ $user->username }}</strong></p>
        <p>Role: <strong>{{ ucfirst($user->role) }}</strong></p>
        <p>Trust Level: <strong>{{ ucfirst($user->trust_level) }}</strong></p>

        <hr style="margin: 1rem 0;">

        <a href="{{ route('id.profile.show') }}" class="btn btn-primary" style="margin-right: 0.5rem;">
            View Profile
        </a>
        <a href="{{ route('id.profile.edit') }}" class="btn btn-primary">
            Edit Profile
        </a>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1rem;">
        <div class="card">
            <h3>Identity Verification</h3>
            <p>Verify your identity to increase your trust level.</p>
            @if ($verification && $verification->type === 'identity')
                <p>
                    Status:
                    <strong>
                        @switch($verification->status)
                            @case('not_submitted')
                                Not Submitted
                                @break
                            @case('pending')
                                Pending Review
                                @break
                            @case('approved')
                                Approved ✓
                                @break
                            @case('rejected')
                                Rejected
                                @break
                        @endswitch
                    </strong>
                </p>
            @endif
            <a href="{{ route('id.verification.show', 'identity') }}" class="btn btn-primary btn-sm">
                {{ ($verification && $verification->status !== 'not_submitted') ? 'View' : 'Submit' }}
            </a>
        </div>

        <div class="card">
            <h3>Security Settings</h3>
            <p>Manage your account security and sessions.</p>
            <a href="{{ route('id.change-password') }}" class="btn btn-primary btn-sm" style="margin-right: 0.5rem;">
                Change Password
            </a>
            <a href="{{ route('id.sessions.index') }}" class="btn btn-info btn-sm">
                Active Sessions
            </a>
        </div>

        <div class="card">
            <h3>Active Sessions</h3>
            <p>You have <strong>{{ $user->getActiveSessionCount() }}</strong> active session(s).</p>
            <p style="font-size: 0.9rem; color: #666; margin-bottom: 0.5rem;">Manage your logins across all devices.</p>
            <a href="{{ route('id.sessions.index') }}" class="btn btn-primary btn-sm">
                View & Manage Sessions
            </a>
        </div>

        <div class="card">
            <h3>Account Info</h3>
            <p>Last login: <strong>{{ $user->last_login ? $user->last_login->format('M d, Y H:i') : 'Never' }}</strong></p>
            <p>Member since: <strong>{{ $user->created_at->format('M d, Y') }}</strong></p>
        </div>
    </div>

    <!-- Noccea Ecosystem Section -->
    <div class="card" style="margin-top: 2rem;">
        <h2 style="margin-bottom: 1rem;"><i class="bi bi-diagram-3"></i> Noccea Ecosystem</h2>
        <p style="color: #666; margin-bottom: 1.5rem;">Access all Noccea platforms with your Africoders account</p>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
            <a href="https://{{ config('domains.noccea.main') }}?auth=true" style="text-decoration: none;">
                <div class="card" style="border: 2px solid #667eea; text-align: center; height: 100%;">
                    <div style="font-size: 2.5rem; color: #667eea; margin-bottom: 0.5rem;">
                        <i class="bi bi-house-door"></i>
                    </div>
                    <h4 style="margin-bottom: 0.5rem; color: #333;">Noccea Hub</h4>
                    <p style="color: #666; font-size: 0.9rem; margin: 0;">Main platform</p>
                </div>
            </a>

            <a href="https://{{ config('domains.noccea.learn') }}?auth=true" style="text-decoration: none;">
                <div class="card" style="border: 2px solid #4299e1; text-align: center; height: 100%;">
                    <div style="font-size: 2.5rem; color: #4299e1; margin-bottom: 0.5rem;">
                        <i class="bi bi-book"></i>
                    </div>
                    <h4 style="margin-bottom: 0.5rem; color: #333;">Learn</h4>
                    <p style="color: #666; font-size: 0.9rem; margin: 0;">Courses & skills</p>
                </div>
            </a>

            <a href="https://{{ config('domains.noccea.community') }}?auth=true" style="text-decoration: none;">
                <div class="card" style="border: 2px solid #48bb78; text-align: center; height: 100%;">
                    <div style="font-size: 2.5rem; color: #48bb78; margin-bottom: 0.5rem;">
                        <i class="bi bi-people"></i>
                    </div>
                    <h4 style="margin-bottom: 0.5rem; color: #333;">Community</h4>
                    <p style="color: #666; font-size: 0.9rem; margin: 0;">Connect & discuss</p>
                </div>
            </a>

            <a href="https://{{ config('domains.noccea.business') }}?auth=true" style="text-decoration: none;">
                <div class="card" style="border: 2px solid #ed8936; text-align: center; height: 100%;">
                    <div style="font-size: 2.5rem; color: #ed8936; margin-bottom: 0.5rem;">
                        <i class="bi bi-briefcase"></i>
                    </div>
                    <h4 style="margin-bottom: 0.5rem; color: #333;">Business</h4>
                    <p style="color: #666; font-size: 0.9rem; margin: 0;">Directory & ventures</p>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
