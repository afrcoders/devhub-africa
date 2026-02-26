@extends('africoders.id.layouts.app')

@section('title', 'Verification')

@section('content')
<div style="max-width: 700px;">
    <h1 style="margin-bottom: 2rem;">{{ ucfirst($verification->type) }} Verification</h1>

    <div class="card">
        <div style="margin-bottom: 2rem;">
            <p style="color: var(--gray-700); font-size: 0.875rem; margin-bottom: 0.25rem;">Status</p>
            <p>
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
        </div>

        @if ($verification->status === 'rejected' && $verification->rejection_reason)
            <div class="alert alert-danger">
                <strong>Rejection Reason:</strong> {{ $verification->rejection_reason }}
            </div>
        @endif

        @if (in_array($verification->status, ['not_submitted', 'rejected']))
            <form action="{{ route('id.verification.submit', $verification->type) }}" method="POST" enctype="multipart/form-data">
                @csrf

                @if ($verification->type === 'identity')
                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" id="first_name" name="first_name" value="{{ old('first_name', $verification->data['first_name'] ?? '') }}" required>
                        @error('first_name')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" id="last_name" name="last_name" value="{{ old('last_name', $verification->data['last_name'] ?? '') }}" required>
                        @error('last_name')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="id_type">ID Type</label>
                        <select id="id_type" name="id_type" required>
                            <option value="">Select ID Type</option>
                            <option value="passport" {{ old('id_type', $verification->data['id_type'] ?? '') === 'passport' ? 'selected' : '' }}>Passport</option>
                            <option value="drivers_license" {{ old('id_type', $verification->data['id_type'] ?? '') === 'drivers_license' ? 'selected' : '' }}>Driver's License</option>
                            <option value="national_id" {{ old('id_type', $verification->data['id_type'] ?? '') === 'national_id' ? 'selected' : '' }}>National ID</option>
                        </select>
                        @error('id_type')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="id_number">ID Number</label>
                        <input type="text" id="id_number" name="id_number" value="{{ old('id_number', $verification->data['id_number'] ?? '') }}" required>
                        @error('id_number')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="id_document">ID Document (optional)</label>
                        <input type="file" id="id_document" name="id_document" accept="image/*,application/pdf">
                        @error('id_document')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                @elseif ($verification->type === 'business')
                    <div class="form-group">
                        <label for="business_name">Business Name</label>
                        <input type="text" id="business_name" name="business_name" value="{{ old('business_name', $verification->data['business_name'] ?? '') }}" required>
                        @error('business_name')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="business_number">Business Registration Number</label>
                        <input type="text" id="business_number" name="business_number" value="{{ old('business_number', $verification->data['business_number'] ?? '') }}" required>
                        @error('business_number')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="business_document">Business Document (optional)</label>
                        <input type="file" id="business_document" name="business_document" accept="image/*,application/pdf">
                        @error('business_document')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                @elseif ($verification->type === 'instructor')
                    <div class="form-group">
                        <label for="qualifications">Qualifications</label>
                        <textarea id="qualifications" name="qualifications" rows="4" required>{{ old('qualifications', $verification->data['qualifications'] ?? '') }}</textarea>
                        @error('qualifications')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="experience_years">Years of Experience</label>
                        <input type="number" id="experience_years" name="experience_years" min="0" value="{{ old('experience_years', $verification->data['experience_years'] ?? '') }}" required>
                        @error('experience_years')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="certificate">Certificate (optional)</label>
                        <input type="file" id="certificate" name="certificate" accept="image/*,application/pdf">
                        @error('certificate')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                @endif

                <button type="submit" class="btn btn-primary" style="margin-right: 0.5rem;">
                    Submit Verification
                </button>
                <a href="{{ route('id.dashboard') }}" class="btn" style="background-color: var(--gray-300); color: var(--gray-900);">
                    Back to Dashboard
                </a>
            </form>
        @else
            <div style="padding: 1.5rem; background-color: var(--gray-100); border-radius: 0.375rem;">
                <p style="margin-bottom: 1rem;">
                    Your {{ $verification->type }} verification has been
                    <strong>{{ ucfirst($verification->status) }}</strong> {{ $verification->reviewed_at ? 'on ' . $verification->reviewed_at->format('M d, Y') : '' }}.
                </p>
                <a href="{{ route('id.dashboard') }}" class="btn btn-primary">
                    Back to Dashboard
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
