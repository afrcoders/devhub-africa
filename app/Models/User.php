<?php

namespace App\Models;

use App\Models\Business\Business;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'full_name',
        'name',
        'username',
        'email',
        'phone',
        'bio',
        'country',
        'profile_picture',
        'password',
        'role',
        'trust_level',
        'email_verified',
        'email_verified_at',
        'phone_verified',
        'is_active',
        'last_login',
        'password_changed_at',
        'posts_count',
        'discussions_count',
        'google_id',
        'github_id',
        'facebook_id',
        'twitter_id',
        'linkedin_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password_changed_at' => 'datetime',
        'last_login' => 'datetime',
        'email_verified' => 'boolean',
        'phone_verified' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Get the email verification tokens for the user.
     */
    public function emailVerificationTokens()
    {
        return $this->hasMany(EmailVerificationToken::class);
    }

    /**
     * Get the sessions for the user.
     */
    public function sessions()
    {
        return $this->hasMany(Session::class);
    }

    /**
     * Get the verifications for the user.
     */
    public function verifications()
    {
        return $this->hasMany(Verification::class);
    }

    /**
     * Get the audit logs for the user.
     */
    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }

    /**
     * Get the password reset tokens for the user.
     */
    public function passwordResetTokens()
    {
        return $this->hasMany(PasswordResetToken::class);
    }

    /**
     * Check if user is admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if email is verified.
     */
    public function hasVerifiedEmail(): bool
    {
        return $this->email_verified;
    }

    /**
     * Mark email as verified.
     */
    public function markEmailAsVerified(): bool
    {
        return $this->forceFill([
            'email_verified' => true,
            'email_verified_at' => now(),
        ])->save();
    }

    /**
     * Sync name with full_name when full_name is set.
     */
    public function setFullNameAttribute($value)
    {
        $this->attributes['full_name'] = $value;
    }

    /**
     * Get name from full_name.
     */
    public function getNameAttribute()
    {
        return $this->attributes['full_name'] ?? null;
    }

    /**
     * Get all active sessions for this user (across devices).
     */
    public function getActiveSessions()
    {
        return $this->sessions()
            ->where('expires_at', '>', now())
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get the count of active sessions.
     */
    public function getActiveSessionCount(): int
    {
        return $this->sessions()
            ->where('expires_at', '>', now())
            ->count();
    }

    /**
     * Log out from all devices/sessions.
     */
    public function logoutAllSessions(): bool
    {
        return $this->sessions()
            ->update(['expires_at' => now()]);
    }

    /**
     * Log out from all sessions except the current one.
     */
    public function logoutOtherSessions($currentSessionToken): bool
    {
        return $this->sessions()
            ->where('session_token', '!=', $currentSessionToken)
            ->update(['expires_at' => now()]);
    }

    // Community Relationships
    public function discussions()
    {
        return $this->hasMany(\App\Models\Community\Discussion::class);
    }

    public function discussionReplies()
    {
        return $this->hasMany(\App\Models\Community\DiscussionReply::class);
    }

    public function discussionVotes()
    {
        return $this->hasMany(\App\Models\Community\DiscussionVote::class);
    }

    public function bookmarkedDiscussions()
    {
        return $this->belongsToMany(\App\Models\Community\Discussion::class, 'discussion_bookmarks')
            ->withTimestamps();
    }

    /**
     * Get the businesses that the user has bookmarked.
     */
    public function bookmarkedBusinesses()
    {
        return $this->belongsToMany(Business::class, 'business_bookmarks')
            ->withTimestamps();
    }

    // Learn Platform Relationships
    public function enrollments()
    {
        return $this->hasMany(\App\Models\Noccea\Learn\CourseEnrollment::class);
    }

    public function completedLessons()
    {
        return $this->hasMany(\App\Models\Noccea\Learn\LessonCompletion::class);
    }
}
