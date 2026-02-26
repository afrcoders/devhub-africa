<?php

namespace App\Models\Help;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $table = 'help_contact_messages';

    protected $fillable = [
        'name',
        'email',
        'type',
        'subject',
        'message',
        'status',
        'admin_notes',
        'ip_address',
        'user_agent',
        'meta'
    ];

    protected $casts = [
        'meta' => 'array'
    ];

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    public function markAsReplied()
    {
        $this->update(['status' => 'replied']);
    }

    public function markAsResolved()
    {
        $this->update(['status' => 'resolved']);
    }

    public function markAsSpam()
    {
        $this->update(['status' => 'spam']);
    }
}
