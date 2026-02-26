<?php

namespace App\Http\Controllers\Africoders\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Verification;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        // Authentication is handled by route-level checks to avoid redirect loops
        // The route will handle authentication and authorization before reaching the controller
    }

    /**
     * Show admin dashboard.
     */
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalVerifications = Verification::count();
        $pendingVerifications = Verification::where('status', 'pending')->count();
        $recentAuditLogs = AuditLog::latest()->take(10)->get();

        return view('admin.dashboard', [
            'totalUsers' => $totalUsers,
            'totalVerifications' => $totalVerifications,
            'pendingVerifications' => $pendingVerifications,
            'recentAuditLogs' => $recentAuditLogs,
        ]);
    }

    /**
     * Show verifications management page.
     */
    public function verifications(Request $request)
    {
        $query = Verification::with('user');

        if ($request->has('status') && $request->input('status') !== '') {
            $query->where('status', $request->input('status'));
        }

        if ($request->has('type') && $request->input('type') !== '') {
            $query->where('type', $request->input('type'));
        }

        $verifications = $query->latest()->paginate(15);

        return view('admin.verifications.index', [
            'verifications' => $verifications,
        ]);
    }

    /**
     * Show verification details.
     */
    public function showVerification($id)
    {
        $verification = Verification::findOrFail($id);

        return view('admin.verifications.show', [
            'verification' => $verification,
        ]);
    }

    /**
     * Approve verification.
     */
    public function approveVerification(Request $request, $id)
    {
        $verification = Verification::findOrFail($id);

        $validated = $request->validate([
            'admin_notes' => ['nullable', 'string'],
        ]);

        $verification->update([
            'status' => 'approved',
            'admin_notes' => $validated['admin_notes'],
        ]);

        // Update user's trust level if identity verification is approved
        if ($verification->type === 'identity') {
            $verification->user->update(['trust_level' => 'verified']);
        }

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'verification_approved',
            'details' => "{$verification->type} verification approved for user {$verification->user->email}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return back()->with('success', 'Verification approved successfully');
    }

    /**
     * Reject verification.
     */
    public function rejectVerification(Request $request, $id)
    {
        $verification = Verification::findOrFail($id);

        $validated = $request->validate([
            'admin_notes' => ['nullable', 'string'],
        ]);

        $verification->update([
            'status' => 'rejected',
            'admin_notes' => $validated['admin_notes'],
        ]);

        // Reset user's trust level if identity verification is rejected
        if ($verification->type === 'identity') {
            $verification->user->update(['trust_level' => 'unverified']);
        }

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'verification_rejected',
            'details' => "{$verification->type} verification rejected for user {$verification->user->email}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return back()->with('success', 'Verification rejected successfully');
    }

    /**
     * Show audit logs.
     */
    public function auditLogs(Request $request)
    {
        $query = AuditLog::with('user');

        if ($request->has('action') && $request->input('action') !== '') {
            $query->where('action', $request->input('action'));
        }

        if ($request->has('user_id') && $request->input('user_id') !== '') {
            $query->where('user_id', $request->input('user_id'));
        }

        $logs = $query->latest()->paginate(20);

        return view('admin.audit-logs.index', [
            'logs' => $logs,
        ]);
    }
}
