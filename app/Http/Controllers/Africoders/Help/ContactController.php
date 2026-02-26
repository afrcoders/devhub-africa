<?php

namespace App\Http\Controllers\Africoders\Help;

use App\Http\Controllers\Controller;
use App\Models\Help\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function show()
    {
        return view('africoders.help.contact');
    }

    public function submit(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
            'subject' => 'required|max:255',
            'message' => 'required|min:10',
            'type' => 'required|in:support,business,legal,other',
            'recaptcha' => 'required|accepted'
        ], [
            'recaptcha.required' => 'Please confirm you are not a robot.',
            'recaptcha.accepted' => 'Please confirm you are not a robot by checking the checkbox.'
        ]);

        try {
            ContactMessage::create([
                'name' => $request->name,
                'email' => $request->email,
                'type' => $request->type,
                'subject' => $request->subject,
                'message' => $request->message,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'meta' => [
                    'referrer' => $request->headers->get('referer'),
                    'submitted_at' => now()->toISOString()
                ]
            ]);

            return redirect()->route('help.contact.success')
                ->with('success', 'Thank you for contacting us! We\'ll get back to you as soon as possible.');

        } catch (\Exception $e) {
            \Log::error('Contact form submission failed', [
                'error' => $e->getMessage(),
                'email' => $request->email,
                'ip' => $request->ip()
            ]);

            return redirect()->route('help.contact.error')
                ->with('error', 'There was an error submitting your message. Please try again.');
        }
    }

    public function success()
    {
        return view('africoders.help.contact-success');
    }

    public function error()
    {
        return view('africoders.help.contact-error');
    }
}
