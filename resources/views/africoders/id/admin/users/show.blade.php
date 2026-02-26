@extends('africoders.id.layouts.app')

@section('title', $user->full_name)

@section('content')
<div class="admin-page">
    <!-- Modern Page Header with User Info -->
    <div class="admin-page-header" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); position: relative; overflow: visible;">
        <!-- Decorative Background Elements -->
        <div style="position: absolute; top: -50px; right: -50px; width: 300px; height: 300px; background: rgba(255, 255, 255, 0.1); border-radius: 50%; pointer-events: none;"></div>
        <div style="position: absolute; bottom: -30px; left: 10%; width: 200px; height: 200px; background: rgba(255, 255, 255, 0.05); border-radius: 50%; pointer-events: none;"></div>

        <div class="container py-5" style="position: relative; z-index: 10;">
            <div style="display: flex; align-items: center; justify-content: space-between; gap: 2rem;">
                <div style="display: flex; align-items: center; gap: 1.5rem;">
                    <!-- User Avatar -->
                    <div style="width: 80px; height: 80px; border-radius: 1rem; background: rgba(255, 255, 255, 0.2); border: 2px solid rgba(255, 255, 255, 0.3); display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px); flex-shrink: 0;">
                        <div style="font-size: 2rem; font-weight: 700; color: white;">
                            {{ strtoupper(substr($user->full_name, 0, 1)) }}
                        </div>
                    </div>
                    <!-- Header Info -->
                    <div>
                        <h1 style="font-size: 1.75rem; font-weight: 700; color: white; margin: 0; padding: 0;">{{ $user->full_name }}</h1>
                        <p style="color: rgba(255, 255, 255, 0.9); font-size: 0.95rem; margin: 0.5rem 0 0 0; padding: 0;">
                            <i class="bi bi-envelope" style="margin-right: 0.5rem;"></i>{{ $user->email }}
                        </p>
                    </div>
                </div>
                <a href="{{ route('admin.users.index') }}" class="btn" style="background-color: rgba(255, 255, 255, 0.2); color: white; border: 1px solid rgba(255, 255, 255, 0.3); border-radius: 0.5rem; padding: 0.5rem 1.25rem; transition: all 0.3s ease; flex-shrink: 0; white-space: nowrap;">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            </div>
        </div>
    </div>

    <div class="container py-5">
        <div class="row gap-4">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Account Information Card -->
                <div class="info-card" style="background: white; border-radius: 1rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08); overflow: hidden; margin-bottom: 1.5rem; border-top: 4px solid #3b82f6;">
                    <div style="padding: 1.5rem 1.75rem; border-bottom: 1px solid #e5e7eb; background: linear-gradient(90deg, rgba(59, 130, 246, 0.02) 0%, rgba(37, 99, 235, 0.02) 100%);">
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <i class="bi bi-person-badge" style="font-size: 1.25rem; color: #3b82f6;"></i>
                            <h5 style="margin: 0; font-size: 1.125rem; font-weight: 700; color: #1f2937;">Account Information</h5>
                        </div>
                    </div>
                    <div style="padding: 2rem;">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label style="display: block; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.75px; color: #9ca3af; margin-bottom: 0.75rem; font-weight: 700;">Full Name</label>
                                <p style="font-size: 1.0625rem; color: #1f2937; margin: 0; font-weight: 600;">{{ $user->full_name }}</p>
                            </div>
                            <div class="col-md-6">
                                <label style="display: block; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.75px; color: #9ca3af; margin-bottom: 0.75rem; font-weight: 700;">Email Address</label>
                                <p style="font-size: 1.0625rem; color: #1f2937; margin: 0; font-weight: 600;">{{ $user->email }}</p>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label style="display: block; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.75px; color: #9ca3af; margin-bottom: 0.75rem; font-weight: 700;">Current Role</label>
                                <div>
                                    @if ($user->isAdmin())
                                        <span class="badge" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; padding: 0.5rem 0.875rem; border-radius: 0.5rem; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; display: inline-block; box-shadow: 0 2px 4px rgba(239, 68, 68, 0.2);"><i class="bi bi-shield-fill" style="margin-right: 0.375rem;"></i>Admin</span>
                                    @else
                                        <span class="badge" style="background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%); color: white; padding: 0.5rem 0.875rem; border-radius: 0.5rem; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; display: inline-block; box-shadow: 0 2px 4px rgba(6, 182, 212, 0.2);"><i class="bi bi-person-fill" style="margin-right: 0.375rem;"></i>Member</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label style="display: block; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.75px; color: #9ca3af; margin-bottom: 0.75rem; font-weight: 700;">Account Status</label>
                                <div>
                                    @if ($user->is_active)
                                        <span class="badge" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 0.5rem 0.875rem; border-radius: 0.5rem; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; display: inline-block; box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2);"><i class="bi bi-check-circle-fill" style="margin-right: 0.375rem;"></i>Active</span>
                                    @else
                                        <span class="badge" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; padding: 0.5rem 0.875rem; border-radius: 0.5rem; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; display: inline-block; box-shadow: 0 2px 4px rgba(239, 68, 68, 0.2);"><i class="bi bi-x-circle-fill" style="margin-right: 0.375rem;"></i>Inactive</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label style="display: block; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.75px; color: #9ca3af; margin-bottom: 0.75rem; font-weight: 700;">Joined Date</label>
                                <p style="font-size: 1rem; color: #1f2937; margin: 0; font-weight: 500;"><i class="bi bi-calendar-event" style="margin-right: 0.375rem; color: #3b82f6;"></i>{{ $user->created_at->format('M d, Y') }}</p>
                            </div>
                            <div class="col-md-6">
                                <label style="display: block; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.75px; color: #9ca3af; margin-bottom: 0.75rem; font-weight: 700;">Last Updated</label>
                                <p style="font-size: 1rem; color: #1f2937; margin: 0; font-weight: 500;"><i class="bi bi-arrow-repeat" style="margin-right: 0.375rem; color: #3b82f6;"></i>{{ $user->updated_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Session Management Card -->
                <div class="info-card" style="background: white; border-radius: 1rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08); overflow: hidden; margin-bottom: 1.5rem; border-top: 4px solid #ef4444;">
                    <div style="padding: 1.5rem 1.75rem; border-bottom: 1px solid #e5e7eb; background: linear-gradient(90deg, rgba(239, 68, 68, 0.02) 0%, rgba(220, 38, 38, 0.02) 100%);">
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <i class="bi bi-box-arrow-right" style="font-size: 1.25rem; color: #ef4444;"></i>
                            <h5 style="margin: 0; font-size: 1.125rem; font-weight: 700; color: #1f2937;">Session Management</h5>
                        </div>
                    </div>
                    <div style="padding: 2rem;">
                        <p style="color: #6b7280; margin-bottom: 1.5rem;">Logout this user from all active sessions across all devices.</p>
                        <form action="{{ route('admin.users.logout-all', $user->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-logout-all" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; border: none; border-radius: 0.5rem; padding: 0.75rem 1.5rem; font-weight: 700; font-size: 0.95rem; cursor: pointer; transition: all 0.3s ease; width: 100%; box-shadow: 0 4px 6px rgba(239, 68, 68, 0.2);" onclick="return confirm('Are you sure you want to logout this user from all devices?');">
                                <i class="bi bi-box-arrow-right"></i> Logout User from All Devices
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Delete User Card (Danger Zone) -->
                <div class="info-card" style="background: white; border-radius: 1rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08); overflow: hidden; margin-bottom: 1.5rem; border-top: 4px solid #991b1b;">
                    <div style="padding: 1.5rem 1.75rem; border-bottom: 1px solid #e5e7eb; background: linear-gradient(90deg, rgba(153, 27, 27, 0.02) 0%, rgba(127, 29, 29, 0.02) 100%);">
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <i class="bi bi-trash" style="font-size: 1.25rem; color: #991b1b;"></i>
                            <h5 style="margin: 0; font-size: 1.125rem; font-weight: 700; color: #1f2937;">Danger Zone</h5>
                        </div>
                    </div>
                    <div style="padding: 2rem;">
                        <p style="color: #6b7280; margin-bottom: 1.5rem;">Permanently delete this user and all associated data from the database. <strong>This action cannot be undone.</strong></p>
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline-block; width: 100%;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete-user" style="background: linear-gradient(135deg, #991b1b 0%, #7f1d1d 100%); color: white; border: none; border-radius: 0.5rem; padding: 0.75rem 1.5rem; font-weight: 700; font-size: 0.95rem; cursor: pointer; transition: all 0.3s ease; width: 100%; box-shadow: 0 4px 6px rgba(153, 27, 27, 0.2);" onclick="return confirm('⚠️ WARNING: This will permanently delete user {{ $user->full_name }} and ALL their data from the database. This action CANNOT be undone. Are you absolutely sure?');">
                                <i class="bi bi-trash"></i> Permanently Delete User
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Edit User Profile Card -->
                <div class="info-card" style="background: white; border-radius: 1rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08); overflow: hidden; border-top: 4px solid #f59e0b;">
                    <div style="padding: 1.5rem 1.75rem; border-bottom: 1px solid #e5e7eb; background: linear-gradient(90deg, rgba(245, 158, 11, 0.02) 0%, rgba(217, 119, 6, 0.02) 100%);">
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <i class="bi bi-pencil-square" style="font-size: 1.25rem; color: #f59e0b;"></i>
                            <h5 style="margin: 0; font-size: 1.125rem; font-weight: 700; color: #1f2937;">Edit User Profile</h5>
                        </div>
                    </div>
                    <div style="padding: 2rem;">
                        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Basic Information -->
                            <div style="margin-bottom: 2rem; padding-bottom: 2rem; border-bottom: 1px solid #e5e7eb;">
                                <h6 style="font-weight: 700; color: #1f2937; margin-bottom: 1rem; font-size: 0.95rem; text-transform: uppercase; letter-spacing: 0.75px; color: #9ca3af;">Basic Information</h6>
                                <div class="row" style="gap: 1rem;">
                                    <div class="col-md-6">
                                        <label for="full_name" style="display: block; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.75px; color: #9ca3af; margin-bottom: 0.75rem; font-weight: 700;">Full Name</label>
                                        <input type="text" id="full_name" name="full_name" value="{{ old('full_name', $user->full_name) }}" class="form-control @error('full_name') is-invalid @enderror" style="border-radius: 0.5rem; border: 2px solid #e5e7eb; padding: 0.625rem 1rem; font-size: 0.95rem; transition: all 0.3s ease; font-weight: 500;" placeholder="Enter full name">
                                        @error('full_name')
                                            <div style="color: #dc2626; font-size: 0.875rem; margin-top: 0.5rem;"><i class="bi bi-exclamation-circle" style="margin-right: 0.375rem;"></i>{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="username" style="display: block; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.75px; color: #9ca3af; margin-bottom: 0.75rem; font-weight: 700;">Username</label>
                                        <input type="text" id="username" name="username" value="{{ old('username', $user->username) }}" class="form-control @error('username') is-invalid @enderror" style="border-radius: 0.5rem; border: 2px solid #e5e7eb; padding: 0.625rem 1rem; font-size: 0.95rem; transition: all 0.3s ease; font-weight: 500;" placeholder="Enter username">
                                        @error('username')
                                            <div style="color: #dc2626; font-size: 0.875rem; margin-top: 0.5rem;"><i class="bi bi-exclamation-circle" style="margin-right: 0.375rem;"></i>{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Information -->
                            <div style="margin-bottom: 2rem; padding-bottom: 2rem; border-bottom: 1px solid #e5e7eb;">
                                <h6 style="font-weight: 700; color: #1f2937; margin-bottom: 1rem; font-size: 0.95rem; text-transform: uppercase; letter-spacing: 0.75px; color: #9ca3af;">Contact Information</h6>
                                <div class="row" style="gap: 1rem;">
                                    <div class="col-md-6">
                                        <label for="email" style="display: block; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.75px; color: #9ca3af; margin-bottom: 0.75rem; font-weight: 700;">Email Address</label>
                                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="form-control @error('email') is-invalid @enderror" style="border-radius: 0.5rem; border: 2px solid #e5e7eb; padding: 0.625rem 1rem; font-size: 0.95rem; transition: all 0.3s ease; font-weight: 500;" placeholder="Enter email address">
                                        @error('email')
                                            <div style="color: #dc2626; font-size: 0.875rem; margin-top: 0.5rem;"><i class="bi bi-exclamation-circle" style="margin-right: 0.375rem;"></i>{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone" style="display: block; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.75px; color: #9ca3af; margin-bottom: 0.75rem; font-weight: 700;">Phone Number</label>
                                        <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" class="form-control @error('phone') is-invalid @enderror" style="border-radius: 0.5rem; border: 2px solid #e5e7eb; padding: 0.625rem 1rem; font-size: 0.95rem; transition: all 0.3s ease; font-weight: 500;" placeholder="Enter phone number">
                                        @error('phone')
                                            <div style="color: #dc2626; font-size: 0.875rem; margin-top: 0.5rem;"><i class="bi bi-exclamation-circle" style="margin-right: 0.375rem;"></i>{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div style="margin-top: 1.5rem;">
                                    <label for="country" style="display: block; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.75px; color: #9ca3af; margin-bottom: 0.75rem; font-weight: 700;">Country</label>
                                    <input type="text" id="country" name="country" value="{{ old('country', $user->country) }}" class="form-control @error('country') is-invalid @enderror" style="border-radius: 0.5rem; border: 2px solid #e5e7eb; padding: 0.625rem 1rem; font-size: 0.95rem; transition: all 0.3s ease; font-weight: 500;" placeholder="Enter country">
                                    @error('country')
                                        <div style="color: #dc2626; font-size: 0.875rem; margin-top: 0.5rem;"><i class="bi bi-exclamation-circle" style="margin-right: 0.375rem;"></i>{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Bio -->
                            <div style="margin-bottom: 2rem; padding-bottom: 2rem; border-bottom: 1px solid #e5e7eb;">
                                <label for="bio" style="display: block; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.75px; color: #9ca3af; margin-bottom: 0.75rem; font-weight: 700;">Bio</label>
                                <textarea id="bio" name="bio" class="form-control @error('bio') is-invalid @enderror" style="border-radius: 0.5rem; border: 2px solid #e5e7eb; padding: 0.625rem 1rem; font-size: 0.95rem; transition: all 0.3s ease; font-weight: 500; min-height: 100px; resize: vertical;" placeholder="Enter user bio">{{ old('bio', $user->bio) }}</textarea>
                                @error('bio')
                                    <div style="color: #dc2626; font-size: 0.875rem; margin-top: 0.5rem;"><i class="bi bi-exclamation-circle" style="margin-right: 0.375rem;"></i>{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password Section -->
                            <div style="margin-bottom: 2rem; padding-bottom: 2rem; border-bottom: 1px solid #e5e7eb;">
                                <h6 style="font-weight: 700; color: #1f2937; margin-bottom: 1rem; font-size: 0.95rem; text-transform: uppercase; letter-spacing: 0.75px; color: #9ca3af;">Change Password (Optional)</h6>
                                <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 1rem;">Leave blank to keep the current password</p>
                                <div class="row" style="gap: 1rem;">
                                    <div class="col-md-6">
                                        <label for="password" style="display: block; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.75px; color: #9ca3af; margin-bottom: 0.75rem; font-weight: 700;">New Password</label>
                                        <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" style="border-radius: 0.5rem; border: 2px solid #e5e7eb; padding: 0.625rem 1rem; font-size: 0.95rem; transition: all 0.3s ease; font-weight: 500;" placeholder="Enter new password">
                                        @error('password')
                                            <div style="color: #dc2626; font-size: 0.875rem; margin-top: 0.5rem;"><i class="bi bi-exclamation-circle" style="margin-right: 0.375rem;"></i>{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="password_confirmation" style="display: block; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.75px; color: #9ca3af; margin-bottom: 0.75rem; font-weight: 700;">Confirm Password</label>
                                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" style="border-radius: 0.5rem; border: 2px solid #e5e7eb; padding: 0.625rem 1rem; font-size: 0.95rem; transition: all 0.3s ease; font-weight: 500;" placeholder="Confirm password">
                                        @error('password_confirmation')
                                            <div style="color: #dc2626; font-size: 0.875rem; margin-top: 0.5rem;"><i class="bi bi-exclamation-circle" style="margin-right: 0.375rem;"></i>{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Role & Status -->
                            <div style="margin-bottom: 2rem;">
                                <h6 style="font-weight: 700; color: #1f2937; margin-bottom: 1rem; font-size: 0.95rem; text-transform: uppercase; letter-spacing: 0.75px; color: #9ca3af;">Role & Status</h6>
                                <div class="row" style="gap: 1rem;">
                                    <div class="col-md-6">
                                        <label for="role" style="display: block; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.75px; color: #9ca3af; margin-bottom: 0.75rem; font-weight: 700;">User Role</label>
                                        <select id="role" name="role" class="form-select @error('role') is-invalid @enderror" style="border-radius: 0.5rem; border: 2px solid #e5e7eb; padding: 0.625rem 1rem; font-size: 0.95rem; transition: all 0.3s ease; font-weight: 500;">
                                            <option value="member" {{ !$user->isAdmin() ? 'selected' : '' }}>Member</option>
                                            <option value="admin" {{ $user->isAdmin() ? 'selected' : '' }}>Admin</option>
                                        </select>
                                        @error('role')
                                            <div style="color: #dc2626; font-size: 0.875rem; margin-top: 0.5rem;"><i class="bi bi-exclamation-circle" style="margin-right: 0.375rem;"></i>{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="is_active" style="display: block; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.75px; color: #9ca3af; margin-bottom: 0.75rem; font-weight: 700;">Account Status</label>
                                        <select id="is_active" name="is_active" class="form-select @error('is_active') is-invalid @enderror" style="border-radius: 0.5rem; border: 2px solid #e5e7eb; padding: 0.625rem 1rem; font-size: 0.95rem; transition: all 0.3s ease; font-weight: 500;">
                                            <option value="1" {{ $user->is_active ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ !$user->is_active ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                        @error('is_active')
                                            <div style="color: #dc2626; font-size: 0.875rem; margin-top: 0.5rem;"><i class="bi bi-exclamation-circle" style="margin-right: 0.375rem;"></i>{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div style="display: flex; gap: 1rem;">
                                <button type="submit" class="btn-update-role" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; border: none; border-radius: 0.5rem; padding: 0.75rem 1.5rem; font-weight: 700; font-size: 0.95rem; cursor: pointer; transition: all 0.3s ease; flex: 1; box-shadow: 0 4px 6px rgba(245, 158, 11, 0.2);">
                                    <i class="bi bi-check-circle"></i> Save Changes
                                </button>
                                <a href="{{ route('admin.users.index') }}" class="btn" style="background: #f3f4f6; color: #1f2937; border: 2px solid #e5e7eb; border-radius: 0.5rem; padding: 0.75rem 1.5rem; font-weight: 700; font-size: 0.95rem; cursor: pointer; transition: all 0.3s ease; text-decoration: none; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-x-circle"></i> Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Verifications Card -->
                <div class="info-card" style="background: white; border-radius: 1rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08); overflow: hidden; margin-bottom: 1.5rem; border-top: 4px solid #3b82f6;">
                    <div style="padding: 1.5rem 1.75rem; border-bottom: 1px solid #e5e7eb; background: linear-gradient(90deg, rgba(59, 130, 246, 0.02) 0%, rgba(37, 99, 235, 0.02) 100%);">
                        <h5 style="margin: 0; font-size: 1.125rem; font-weight: 700; color: #1f2937; display: flex; align-items: center; gap: 0.75rem;">
                            <i class="bi bi-shield-check" style="font-size: 1.25rem; color: #3b82f6;"></i> Verifications
                        </h5>
                    </div>
                    <div style="padding: 1.5rem;">
                        @if ($verifications->count() > 0)
                            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                                @foreach ($verifications as $verification)
                                    <a href="{{ route('admin.verifications.show', $verification->id) }}" class="verification-item" style="display: block; padding: 1rem 1.125rem; background: #f9fafb; border-radius: 0.75rem; border-left: 4px solid {{ $verification->status === 'approved' ? '#10b981' : ($verification->status === 'rejected' ? '#ef4444' : '#f59e0b') }}; text-decoration: none; transition: all 0.3s ease; position: relative; overflow: hidden;">
                                        <div style="position: absolute; top: 0; right: -20px; width: 40px; height: 40px; background: {{ $verification->status === 'approved' ? 'rgba(16, 185, 129, 0.1)' : ($verification->status === 'rejected' ? 'rgba(239, 68, 68, 0.1)' : 'rgba(245, 158, 11, 0.1)') }}; border-radius: 50%;"></div>
                                        <div style="display: flex; justify-content: space-between; align-items: flex-start; position: relative; z-index: 1;">
                                            <div>
                                                <h6 style="margin: 0 0 0.5rem 0; font-weight: 700; color: #1f2937; font-size: 0.95rem;">{{ ucfirst($verification->type) }}</h6>
                                                <span class="badge" style="background: {{ $verification->status === 'approved' ? 'linear-gradient(135deg, #10b981 0%, #059669 100%)' : ($verification->status === 'rejected' ? 'linear-gradient(135deg, #ef4444 0%, #dc2626 100%)' : 'linear-gradient(135deg, #f59e0b 0%, #d97706 100%)') }}; color: white; padding: 0.35rem 0.6rem; border-radius: 0.35rem; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; display: inline-block;">
                                                    {{ ucfirst($verification->status) }}
                                                </span>
                                            </div>
                                            <small style="color: #9ca3af; font-size: 0.75rem; font-weight: 500;">{{ $verification->created_at->format('M d') }}</small>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <div style="text-align: center; padding: 2rem 0;">
                                <i class="bi bi-inbox" style="font-size: 2.5rem; color: #d1d5db;"></i>
                                <p style="color: #9ca3af; margin-top: 1rem; font-size: 0.95rem; font-weight: 500;">No verifications yet</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Recent Activity Card -->
                <div class="info-card" style="background: white; border-radius: 1rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08); overflow: hidden; border-top: 4px solid #06b6d4;">
                    <div style="padding: 1.5rem 1.75rem; border-bottom: 1px solid #e5e7eb; background: linear-gradient(90deg, rgba(6, 182, 212, 0.02) 0%, rgba(8, 145, 178, 0.02) 100%);">
                        <h5 style="margin: 0; font-size: 1.125rem; font-weight: 700; color: #1f2937; display: flex; align-items: center; gap: 0.75rem;">
                            <i class="bi bi-clock-history" style="font-size: 1.25rem; color: #06b6d4;"></i> Recent Activity
                        </h5>
                    </div>
                    <div style="padding: 1.5rem;">
                        @if ($auditLogs->count() > 0)
                            <div style="position: relative; padding-left: 1.75rem;">
                                <div style="position: absolute; left: 0.375rem; top: 0; bottom: 0; width: 2px; background: linear-gradient(180deg, #06b6d4 0%, #d1d5db 100%);"></div>
                                @foreach ($auditLogs as $log)
                                    <div style="margin-bottom: 1.5rem; position: relative;">
                                        <div style="position: absolute; left: -2rem; top: 0.25rem; width: 0.875rem; height: 0.875rem; background: white; border-radius: 50%; border: 3px solid #06b6d4; box-shadow: 0 0 0 2px #f9fafb;"></div>
                                        <p style="margin: 0 0 0.35rem 0; font-weight: 700; color: #1f2937; font-size: 0.95rem;">
                                            @switch($log->action)
                                                @case('login_success')
                                                    <i class="bi bi-box-arrow-in-right" style="margin-right: 0.375rem; color: #10b981;"></i>
                                                @break
                                                @case('password_changed')
                                                    <i class="bi bi-shield-lock" style="margin-right: 0.375rem; color: #f59e0b;"></i>
                                                @break
                                                @default
                                                    <i class="bi bi-info-circle" style="margin-right: 0.375rem; color: #3b82f6;"></i>
                                            @endswitch
                                            {{ ucfirst(str_replace('_', ' ', $log->action)) }}
                                        </p>
                                        <p style="margin: 0 0 0.35rem 0; color: #6b7280; font-size: 0.875rem;">{{ $log->details }}</p>
                                        <small style="color: #9ca3af; font-size: 0.8rem;">{{ $log->created_at->diffForHumans() }}</small>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div style="text-align: center; padding: 2rem 0;">
                                <i class="bi bi-graph-up" style="font-size: 2.5rem; color: #d1d5db;"></i>
                                <p style="color: #9ca3af; margin-top: 1rem; font-size: 0.95rem; font-weight: 500;">No activity yet</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --admin-primary: #3b82f6;
        --admin-success: #10b981;
        --admin-warning: #f59e0b;
        --admin-danger: #ef4444;
        --admin-info: #0ea5e9;
        --admin-dark: #1f2937;
        --admin-light: #f9fafb;
        --admin-border: #e5e7eb;
    }

    .admin-page {
        background: linear-gradient(135deg, #f3f4f6 0%, #f9fafb 100%);
        min-height: 100vh;
    }

    .admin-page-header {
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        position: relative;
    }

    .info-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .info-card:hover {
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        transform: translateY(-4px);
    }

    .verification-item:hover {
        background-color: #f0f9ff;
        transform: translateX(4px);
    }

    .form-select {
        transition: all 0.3s ease;
    }

    .form-select:focus {
        border-color: var(--admin-primary) !important;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1) !important;
        outline: none;
    }

    .form-control {
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: var(--admin-primary) !important;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1) !important;
        outline: none;
    }

    .form-control.is-invalid,
    .form-select.is-invalid {
        border-color: var(--admin-danger) !important;
    }

    .form-control.is-invalid:focus,
    .form-select.is-invalid:focus {
        box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1) !important;
    }

    .btn-update-role {
        position: relative;
        overflow: hidden;
    }

    .btn-update-role:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(245, 158, 11, 0.3) !important;
    }

    .btn-update-role:active {
        transform: translateY(0);
    }

    .btn-logout-all {
        position: relative;
        overflow: hidden;
    }

    .btn-logout-all:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(239, 68, 68, 0.3) !important;
    }

    .btn-logout-all:active {
        transform: translateY(0);
    }

    .btn-delete-user {
        position: relative;
        overflow: hidden;
    }

    .btn-delete-user:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(153, 27, 27, 0.3) !important;
    }

    .btn-delete-user:active {
        transform: translateY(0);
    }

    .badge {
        display: inline-block;
        font-size: 0.8rem;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .admin-page-header {
            padding-top: 1rem !important;
            padding-bottom: 1rem !important;
        }

        .admin-page-header h1 {
            font-size: 1.5rem !important;
        }

        .admin-page-header .d-flex {
            flex-direction: column;
            gap: 1rem;
        }

        .admin-page-header .btn {
            padding: 0.5rem 1rem !important;
            font-size: 0.85rem;
            width: 100%;
        }

        .container.py-5 {
            padding: 1.5rem 1rem !important;
        }

        .col-lg-8,
        .col-lg-4 {
            margin-bottom: 1.5rem;
        }

        .row.gap-4 {
            gap: 0 !important;
        }

        .info-card {
            border-radius: 0.875rem;
        }

        .info-card > div:first-child {
            padding: 1.25rem !important;
        }

        .info-card > div:last-child {
            padding: 1.25rem !important;
        }
    }

    @media (max-width: 576px) {
        .admin-page-header h1 {
            font-size: 1.25rem !important;
        }

        .info-card {
            border-radius: 0.75rem;
        }

        .info-card > div:first-child {
            padding: 1rem !important;
        }

        .info-card > div:last-child {
            padding: 1rem !important;
        }

        label {
            font-size: 0.7rem !important;
        }

        p, small {
            font-size: 0.9rem !important;
        }
    }
</style>
@endsection
