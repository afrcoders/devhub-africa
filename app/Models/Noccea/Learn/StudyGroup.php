<?php

namespace App\Models\Noccea\Learn;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class StudyGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category',
        'created_by',
        'next_meeting_at',
        'meeting_link',
        'max_members',
        'is_active',
    ];

    protected $casts = [
        'next_meeting_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'study_group_members')
            ->withPivot('role')
            ->withTimestamps();
    }

    public function studyGroupMembers()
    {
        return $this->hasMany(StudyGroupMember::class);
    }

    public function messages()
    {
        return $this->hasMany(StudyGroupMessage::class);
    }

    public function isMember($userId)
    {
        return $this->members()->where('user_id', $userId)->exists();
    }

    public function isAdmin($userId)
    {
        return $this->members()
            ->where('user_id', $userId)
            ->wherePivot('role', 'admin')
            ->exists();
    }

    public function isFull()
    {
        return $this->members()->count() >= $this->max_members;
    }

    public function membersCount()
    {
        return $this->members()->count();
    }
}
