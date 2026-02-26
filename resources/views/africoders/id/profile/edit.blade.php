@extends('africoders.id.layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div style="max-width: 600px;">
    <h1 style="margin-bottom: 2rem;">Edit Profile</h1>

    <div class="card">
        <form action="{{ route('id.profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="full_name">Full Name</label>
                <input type="text" id="full_name" name="full_name" value="{{ old('full_name', $user->full_name) }}" required>
                @error('full_name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                @error('phone')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="country">Country</label>
                <input type="text" id="country" name="country" value="{{ old('country', $user->country) }}">
                @error('country')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="bio">Bio</label>
                <textarea id="bio" name="bio" rows="4" style="resize: vertical;">{{ old('bio', $user->bio) }}</textarea>
                @error('bio')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary" style="margin-right: 0.5rem;">
                Save Changes
            </button>
            <a href="{{ route('id.profile.show') }}" class="btn" style="background-color: var(--gray-300); color: var(--gray-900);">
                Cancel
            </a>
        </form>
    </div>
</div>
@endsection
