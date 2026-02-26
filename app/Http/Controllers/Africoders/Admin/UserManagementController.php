<?php

namespace App\Http\Controllers\Africoders\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->isAdmin()) {
                abort(403, 'Unauthorized');
            }
            return $next($request);
        });
    }

    /**
     * Show users management page.
     */
    public function users(Request $request)
    {
        $query = User::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('email', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhere('full_name', 'like', "%{$search}%");
        }

        if ($request->has('role') && $request->input('role') !== '') {
            $query->where('role', $request->input('role'));
        }

        $users = $query->paginate(15);

        return view('admin.users.index', [
            'users' => $users,
        ]);
    }

    /**
     * Show user details.
     */
    public function showUser($id)
    {
        $user = User::findOrFail($id);
        $verifications = $user->verifications()->get();
        $auditLogs = $user->auditLogs()->latest()->take(20)->get();

        return view('admin.users.show', [
            'user' => $user,
            'verifications' => $verifications,
            'auditLogs' => $auditLogs,
        ]);
    }

    /**
     * Update user role.
     */
    public function updateRole(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'role' => ['required', 'in:admin,member,business_owner'],
        ]);

        $user->update(['role' => $validated['role']]);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'user_role_updated',
            'details' => "User {$user->email} role updated to {$validated['role']}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return back()->with('success', 'User role updated successfully');
    }

    /**
     * Update user profile (full profile edit).
     */
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,' . $id],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $id],
            'phone' => ['nullable', 'string', 'max:20'],
            'bio' => ['nullable', 'string', 'max:500'],
            'country' => ['nullable', 'string', 'max:100'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:admin,member,business_owner'],
            'is_active' => ['required', 'boolean'],
        ]);

        // Handle password update separately
        $passwordChanged = false;
        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
            $validated['password_changed_at'] = now();
            $passwordChanged = true;
        } else {
            unset($validated['password']);
        }

        unset($validated['password_confirmation']);

        $user->update($validated);

        // If password was changed, logout user from all devices for security
        if ($passwordChanged) {
            $user->logoutAllSessions();
            $auditDetails = "User {$user->email} profile updated and password changed - all sessions ended";
        } else {
            $auditDetails = "User {$user->email} profile updated";
        }

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'user_profile_updated',
            'details' => $auditDetails,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        $message = $passwordChanged
            ? 'User profile updated and password changed. User has been logged out from all devices for security.'
            : 'User profile updated successfully';
        return back()->with('success', $message);
    }

    /**
     * Deactivate user.
     */
    public function deactivateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => 'Cannot deactivate your own account']);
        }

        $user->update(['is_active' => false]);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'user_deactivated',
            'details' => "User {$user->email} deactivated",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return back()->with('success', 'User deactivated successfully');
    }

    /**
     * Log out a user from all sessions (admin function).
     */
    public function logoutAllSessions(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => 'Cannot logout your own account']);
        }

        $user->logoutAllSessions();

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'user_logout_all_sessions',
            'details' => "Logged out user {$user->email} from all sessions",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return back()->with('success', "User {$user->full_name} has been logged out from all devices.");
    }

    /**
     * Delete a user completely from the database.
     */
    public function deleteUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => 'Cannot delete your own account']);
        }

        $userEmail = $user->email;
        $userName = $user->full_name;

        // Log action before deletion
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'user_deleted',
            'details' => "User {$userEmail} ({$userName}) deleted from database",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // Delete user - this will cascade delete related records
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', "User {$userName} has been permanently deleted from the database.");
    }
}
