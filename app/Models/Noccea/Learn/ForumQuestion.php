<?php

namespace App\Models\Noccea\Learn;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class ForumQuestion extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'title',
        'slug',
        'body',
        'views',
        'votes',
        'answered_at',
    ];

    protected $casts = [
        'answered_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->slug) {
                $slug = Str::slug($model->title);
                $count = self::where('slug', 'like', $slug . '%')->count();
                $model->slug = $count ? "{$slug}-{$count}" : $slug;
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(ForumAnswer::class, 'question_id')->orderByDesc('is_accepted')->latest();
    }

    public function votes(): HasMany
    {
        return $this->hasMany(ForumVote::class, 'voteable_id')
            ->where('voteable_type', self::class);
    }

    public function bookmarks(): HasMany
    {
        return $this->hasMany(ForumBookmark::class, 'question_id', 'id');
    }

    public function isAnswered(): bool
    {
        return $this->answered_at !== null;
    }

    public function userVote($userId): ?int
    {
        $vote = $this->votes()
            ->where('user_id', $userId)
            ->first();
        return $vote?->vote;
    }

    public function isBookmarkedBy($userId): bool
    {
        return $this->bookmarks()
            ->where('user_id', $userId)
            ->exists();
    }

    public function updateVoteCount()
    {
        $this->votes = $this->votes()->sum('vote');
        $this->save();
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
