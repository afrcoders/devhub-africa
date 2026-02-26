<?php

namespace App\Http\Controllers\Africoders\Id;

use App\Http\Controllers\Controller;
use App\Models\Verification;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show($type = 'identity')
    {
        $user = auth()->user();
        $verification = $user->verifications()->where('type', $type)->first();

        // Create verification record if it doesn't exist
        if (!$verification) {
            $verification = $user->verifications()->create([
                'type' => $type,
                'status' => 'not_submitted',
            ]);
        }

        return view('africoders.id.verification.show', [
            'verification' => $verification,
            'user' => $user,
        ]);
    }

    public function submit(Request $request, $type = 'identity')
    {
        $user = auth()->user();
        $verification = $user->verifications()->where('type', $type)->first();

        // Create verification record if it doesn't exist
        if (!$verification) {
            $verification = $user->verifications()->create([
                'type' => $type,
                'status' => 'not_submitted',
            ]);
        }

        // Validate based on type
        $validated = match ($type) {
            'identity' => $request->validate([
                'first_name' => ['required', 'string'],
                'last_name' => ['required', 'string'],
                'date_of_birth' => ['required', 'date'],
                'government_id' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            ]),
            'address' => $request->validate([
                'street' => ['required', 'string'],
                'city' => ['required', 'string'],
                'state' => ['required', 'string'],
                'postal_code' => ['required', 'string'],
                'country' => ['required', 'string'],
                'address_proof' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            ]),
            'business' => $request->validate([
                'business_name' => ['required', 'string'],
                'business_registration' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
                'business_type' => ['required', 'string'],
                'tax_id' => ['required', 'string'],
            ]),
            default => [],
        };

        // Handle file uploads
        foreach ($validated as $field => $value) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $path = $file->store("verifications/{$user->id}/{$type}", 'public');
                $verification->update([
                    "{$field}_path" => $path,
                ]);
            }
        }

        // Update verification record
        $verification->update([
            'status' => 'pending',
            'submitted_at' => now(),
        ]);

        \App\Models\AuditLog::create([
            'user_id' => $user->id,
            'action' => 'verification_submitted',
            'details' => "{$type} verification submitted for review",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('id.verification.show', ['type' => $type])
            ->with('success', 'Verification submitted for review. We will review your submission and get back to you within 24-48 hours.');
    }
}
