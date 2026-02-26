<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'user_id',
        'session_token',
        'password_changed_at',
        'browser_info',
        'ip_address',
        'expires_at',
        'data',
    ];

    protected $casts = [
        'password_changed_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    /**
     * Get the user for this session.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if session is expired.
     */
    public function isExpired(): bool
    {
        return now()->isAfter($this->expires_at);
    }

    /**
     * Check if session is valid.
     */
    public function isValid(): bool
    {
        if ($this->isExpired()) {
            return false;
        }

        // Check if user's password was changed after session creation
        if (empty($this->password_changed_at) || empty($this->user->password_changed_at)) {
            return true;
        }

        return $this->user->password_changed_at->lessThanOrEqualTo($this->password_changed_at);
    }
}
