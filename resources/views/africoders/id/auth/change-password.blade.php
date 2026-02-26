@extends('africoders.id.layouts.app')

@section('title', 'Change Password')

@section('content')
<style>
    :root {
        --color-primary: #1E3A8A;
        --color-secondary: #0F172A;
        --color-success: #22C55E;
        --color-warning: #F59E0B;
        --color-danger: #EF4444;
        --color-bg: #F8FAFC;
    }

    * {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }

    body {
        background-color: var(--color-bg);
        color: #1f2937;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: #1f2937;
    }

    .form-group input {
        width: 100%;
        padding: 0.625rem 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        font-size: 0.95rem;
        transition: all 0.2s;
    }

    .form-group input:focus {
        outline: none;
        border-color: var(--color-primary);
        box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
    }

    .error {
        color: #dc2626;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    .btn {
        padding: 0.625rem 1rem;
        border: none;
        border-radius: 0.375rem;
        cursor: pointer;
        font-size: 1rem;
        text-decoration: none;
        display: inline-block;
        transition: all 0.2s;
        font-weight: 500;
    }

    .btn-primary {
        background-color: var(--color-primary);
        color: white;
        border-color: var(--color-primary);
    }

    .btn-primary:hover {
        background-color: #1e40af;
        border-color: #1e40af;
    }

    .w-100 {
        width: 100%;
    }

    .card {
        background: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        padding: 2rem;
    }

    h1 {
        font-size: 1.875rem;
        font-weight: 700;
        color: #111827;
    }
</style>

<div style="max-width: 500px; margin: 3rem auto;">
    <div class="card">
        <h1 style="margin-bottom: 1.5rem;">Change Password</h1>

        <form action="{{ route('id.change-password.submit') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="current_password">Current Password</label>
                <div style="display: flex; align-items: center; gap: 0;">
                    <input type="password" id="current_password" name="current_password" required style="flex: 1; border-radius: 0.375rem 0 0 0.375rem;">
                    <button type="button" onclick="togglePasswordVisibility('current_password')" style="background-color: white; border: 1px solid #d1d5db; border-left: none; border-radius: 0 0.375rem 0.375rem 0; cursor: pointer; padding: 0.625rem 0.75rem; color: var(--color-primary); font-size: 1rem; display: flex; align-items: center; justify-content: center; min-width: 40px;">
                        <i class="bi bi-eye-slash" id="current_password-toggle-icon" style="font-size: 1.125rem;"></i>
                    </button>
                </div>
                @error('current_password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="new_password">New Password (minimum 6 characters)</label>
                <div style="display: flex; align-items: center; gap: 0;">
                    <input type="password" id="new_password" name="new_password" required style="flex: 1; border-radius: 0.375rem 0 0 0.375rem;">
                    <button type="button" onclick="togglePasswordVisibility('new_password')" style="background-color: white; border: 1px solid #d1d5db; border-left: none; border-radius: 0 0.375rem 0.375rem 0; cursor: pointer; padding: 0.625rem 0.75rem; color: var(--color-primary); font-size: 1rem; display: flex; align-items: center; justify-content: center; min-width: 40px;">
                        <i class="bi bi-eye-slash" id="new_password-toggle-icon" style="font-size: 1.125rem;"></i>
                    </button>
                </div>
                @error('new_password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100">
                Change Password
            </button>
        </form>
    </div>
</div>

<script>
    function togglePasswordVisibility(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = document.getElementById(fieldId + '-toggle-icon');
        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        } else {
            field.type = 'password';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        }
    }
</script>

@endsection
