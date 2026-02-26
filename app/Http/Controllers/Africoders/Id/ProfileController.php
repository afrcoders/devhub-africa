<?php

namespace App\Http\Controllers\Africoders\Id;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        $user = auth()->user();
        $verifications = $user->verifications()->get()->keyBy('type');

        return view('africoders.id.profile.show', [
            'user' => $user,
            'verifications' => $verifications,
        ]);
    }

    public function edit()
    {
        return view('africoders.id.profile.edit', [
            'user' => auth()->user(),
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'bio' => ['nullable', 'string'],
            'country' => ['nullable', 'string', 'max:100'],
        ]);

        auth()->user()->update($validated);

        \App\Models\AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'profile_updated',
            'details' => 'User updated profile information',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('id.profile.show')
            ->with('success', 'Profile updated successfully');
    }
}
