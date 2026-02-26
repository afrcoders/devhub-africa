<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthNonce extends Model
{
    protected $fillable = [
        'user_id',
        'nonce',
        'return_url',
        'expires_at',
        'used_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used_at' => 'datetime',
    ];

    /**
     * Get the user associated with this nonce
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if nonce is still valid
     */
    public function isValid(): bool
    {
        // Must not be used
        if ($this->used_at) {
            return false;
        }

        // Must not be expired
        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        return true;
    }

    /**
     * Mark nonce as used
     */
    public function markAsUsed(): void
    {
        $this->update(['used_at' => now()]);
    }

    /**
     * Scope to get valid nonces
     */
    public function scopeValid($query)
    {
        return $query->where('used_at', null)
            ->where(function ($q) {
                $q->whereNull('expires_at')
                  ->orWhere('expires_at', '>', now());
            });
    }
}
