<?php

namespace App\Http\Controllers\Africoders\Id;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    /**
     * Show active sessions for the authenticated user.
     */
    public function index()
    {
        $user = Auth::user();
        $sessions = $user->getActiveSessions();
        $currentSessionToken = session('session_token');

        return view('africoders.id.sessions.index', [
            'sessions' => $sessions,
            'currentSessionToken' => $currentSessionToken,
        ]);
    }

    /**
     * Log out from all devices.
     */
    public function logoutAll(Request $request)
    {
        $user = Auth::user();
        $user->logoutAllSessions();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'You have been logged out from all devices.');
    }

    /**
     * Log out from a specific session/device.
     */
    public function logoutSession(Request $request, $sessionToken)
    {
        $user = Auth::user();
        $session = $user->sessions()->where('session_token', $sessionToken)->first();

        if (!$session) {
            return back()->with('error', 'Session not found.');
        }

        // Don't allow user to logout their current session
        if ($session->session_token === session('session_token')) {
            return back()->with('error', 'Cannot logout from current session. Use "Logout All" instead.');
        }

        $session->update(['expires_at' => now()]);

        return back()->with('success', 'Session terminated successfully.');
    }

    /**
     * Log out a user from all sessions (admin function).
     */
    public function adminLogoutUser(Request $request, $userId)
    {
        $user = \App\Models\User::findOrFail($userId);
        $user->logoutAllSessions();

        // Create audit log
        \App\Models\AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'user_logout_all_sessions',
            'details' => "Logged out user #{$userId} ({$user->full_name}) from all sessions",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return back()->with('success', "User {$user->full_name} has been logged out from all devices.");
    }
}
