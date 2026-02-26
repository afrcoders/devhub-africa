<?php

namespace App\Models\Noccea\Learn;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CourseLesson extends Model
{
    protected $fillable = [
        'module_id',
        'title',
        'content',
        'video_url',
        'duration_minutes',
        'order',
    ];

    public function module(): BelongsTo
    {
        return $this->belongsTo(CourseModule::class, 'module_id');
    }

    public function completions(): HasMany
    {
        return $this->hasMany(LessonCompletion::class, 'lesson_id');
    }

    public function isCompletedBy($userId): bool
    {
        return $this->completions()
            ->where('user_id', $userId)
            ->exists();
    }
}
