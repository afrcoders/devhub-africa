@extends('africoders.id.layouts.app')

@section('title', 'Active Sessions')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <!-- Sessions Header -->
            <div style="margin-bottom: 2rem;">
                <h1 style="font-size: 2rem; font-weight: 700; color: #1f2937; margin-bottom: 0.5rem;">Active Sessions</h1>
                <p style="color: #6b7280; font-size: 1rem; margin: 0;">Manage your active sessions across all devices</p>
            </div>

            <!-- Active Sessions Count -->
            <div style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; padding: 1.5rem; border-radius: 0.75rem; margin-bottom: 2rem; box-shadow: 0 4px 6px rgba(59, 130, 246, 0.2);">
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <div>
                        <p style="margin: 0 0 0.5rem 0; opacity: 0.9; font-size: 0.95rem;">Total Active Sessions</p>
                        <h2 style="margin: 0; font-size: 2.5rem; font-weight: 700;">{{ $sessions->count() }}</h2>
                    </div>
                    <div style="font-size: 3rem; opacity: 0.3;">
                        <i class="bi bi-device-ssd"></i>
                    </div>
                </div>
            </div>

            @if ($sessions->count() > 0)
                <!-- Sessions List -->
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    @foreach ($sessions as $session)
                        <div style="background: white; border: 1px solid #e5e7eb; border-radius: 0.75rem; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);">
                            <div style="display: flex; align-items: start; justify-content: space-between; gap: 1rem;">
                                <div style="flex: 1;">
                                    <!-- Device Info -->
                                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem;">
                                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; color: white;">
                                            <i class="bi bi-phone"></i>
                                        </div>
                                        <div>
                                            <h5 style="margin: 0 0 0.25rem 0; font-weight: 700; color: #1f2937; font-size: 1rem;">
                                                {{ $session->browser_info ?? 'Unknown Device' }}
                                            </h5>
                                            <p style="margin: 0; color: #9ca3af; font-size: 0.875rem;">
                                                <i class="bi bi-geo-alt" style="margin-right: 0.375rem;"></i>{{ $session->ip_address ?? 'IP Unknown' }}
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Session Details -->
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #f3f4f6;">
                                        <div>
                                            <p style="margin: 0 0 0.25rem 0; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.75px; color: #9ca3af; font-weight: 700;">Last Active</p>
                                            <p style="margin: 0; color: #1f2937; font-weight: 500;">{{ $session->updated_at->format('M d, Y H:i') }}</p>
                                        </div>
                                        <div>
                                            <p style="margin: 0 0 0.25rem 0; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.75px; color: #9ca3af; font-weight: 700;">Expires</p>
                                            <p style="margin: 0; color: #1f2937; font-weight: 500;">{{ $session->expires_at->format('M d, Y H:i') }}</p>
                                        </div>
                                    </div>

                                    @if ($session->session_token === $currentSessionToken)
                                        <div style="margin-top: 1rem;">
                                            <span style="display: inline-block; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 0.35rem 0.6rem; border-radius: 0.35rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">
                                                <i class="bi bi-check-circle" style="margin-right: 0.375rem;"></i>Current Session
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Logout Button -->
                                @if ($session->session_token !== $currentSessionToken)
                                    <form action="{{ route('id.sessions.logout-session', $session->session_token) }}" method="POST" style="margin: 0;">
                                        @csrf
                                        <button type="submit" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; border: none; border-radius: 0.5rem; padding: 0.5rem 1rem; font-size: 0.875rem; font-weight: 700; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 2px 4px rgba(239, 68, 68, 0.2);" onclick="return confirm('Are you sure you want to logout from this session?');">
                                            <i class="bi bi-box-arrow-right" style="margin-right: 0.375rem;"></i> Logout
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Logout All Button -->
                <div style="margin-top: 2rem; padding-top: 2rem; border-top: 2px solid #f3f4f6;">
                    <form action="{{ route('id.sessions.logout-all') }}" method="POST" style="display: inline-block; width: 100%;">
                        @csrf
                        <button type="submit" style="width: 100%; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; border: none; border-radius: 0.5rem; padding: 0.75rem 1.5rem; font-weight: 700; font-size: 1rem; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 6px rgba(245, 158, 11, 0.2);" onclick="return confirm('This will logout you from all devices. Are you sure?');">
                            <i class="bi bi-box-arrow-right"></i> Logout from All Devices
                        </button>
                    </form>
                </div>
            @else
                <div style="background: white; border: 1px solid #e5e7eb; border-radius: 0.75rem; padding: 3rem 2rem; text-align: center;">
                    <i class="bi bi-inbox" style="font-size: 2.5rem; color: #d1d5db; display: block; margin-bottom: 1rem;"></i>
                    <h4 style="color: #6b7280; margin-bottom: 0.5rem;">No Active Sessions</h4>
                    <p style="color: #9ca3af; margin: 0;">You don't have any active sessions at the moment.</p>
                </div>
            @endif
        </div>

        <!-- Info Sidebar -->
        <div class="col-lg-4">
            <div style="background: white; border: 1px solid #e5e7eb; border-radius: 0.75rem; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);">
                <h5 style="margin: 0 0 1rem 0; font-weight: 700; color: #1f2937; display: flex; align-items: center; gap: 0.75rem;">
                    <i class="bi bi-info-circle" style="font-size: 1.25rem; color: #3b82f6;"></i> About Sessions
                </h5>
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    <div>
                        <h6 style="margin: 0 0 0.5rem 0; color: #1f2937; font-weight: 700; font-size: 0.95rem;">What is a session?</h6>
                        <p style="margin: 0; color: #6b7280; font-size: 0.875rem;">A session represents an active login on a specific device or browser. You can manage all your sessions from this page.</p>
                    </div>
                    <div style="border-top: 1px solid #e5e7eb; padding-top: 1rem;">
                        <h6 style="margin: 0 0 0.5rem 0; color: #1f2937; font-weight: 700; font-size: 0.95rem;">Security Tip</h6>
                        <p style="margin: 0; color: #6b7280; font-size: 0.875rem;">Regularly review your active sessions and logout from any devices you don't recognize for better security.</p>
                    </div>
                    <div style="border-top: 1px solid #e5e7eb; padding-top: 1rem;">
                        <h6 style="margin: 0 0 0.5rem 0; color: #1f2937; font-weight: 700; font-size: 0.95rem;">Session Timeout</h6>
                        <p style="margin: 0; color: #6b7280; font-size: 0.875rem;">Sessions automatically expire after 1 year of inactivity. You can logout manually at any time.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
