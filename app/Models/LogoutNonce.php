<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogoutNonce extends Model
{
    use HasFactory;

    protected $table = 'logout_nonces';

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
     * Relationship: Logout nonce belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if the nonce is still valid.
     */
    public function isValid(): bool
    {
        return !$this->used_at && $this->expires_at > now();
    }

    /**
     * Mark the nonce as used.
     */
    public function markAsUsed(): void
    {
        $this->update(['used_at' => now()]);
    }

    /**
     * Query scope for valid nonces.
     */
    public function scopeValid($query)
    {
        return $query->whereNull('used_at')
                     ->where('expires_at', '>', now());
    }
}
