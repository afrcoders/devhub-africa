<?php

namespace App\Models\Community;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Discussion extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'category_id',
        'user_id',
        'title',
        'slug',
        'body',
        'is_pinned',
        'is_locked',
        'views_count',
        'replies_count',
        'upvotes_count',
        'downvotes_count',
        'best_reply_id',
        'last_activity_at'
    ];

    protected $casts = [
        'is_pinned' => 'boolean',
        'is_locked' => 'boolean',
        'last_activity_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($discussion) {
            if (!$discussion->uuid) {
                $discussion->uuid = Str::uuid();
            }
            if (!$discussion->slug) {
                $discussion->slug = Str::slug($discussion->title);
            }
            $discussion->last_activity_at = now();
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(DiscussionCategory::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function replies(): HasMany
    {
        return $this->hasMany(DiscussionReply::class);
    }

    public function bestReply(): BelongsTo
    {
        return $this->belongsTo(DiscussionReply::class, 'best_reply_id');
    }

    public function votes(): HasMany
    {
        return $this->hasMany(DiscussionVote::class, 'votable_id')
            ->where('votable_type', 'discussion');
    }

    public function bookmarks(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'discussion_bookmarks')
            ->withTimestamps();
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopePinned($query)
    {
        return $query->where('is_pinned', true);
    }

    public function scopeNotPinned($query)
    {
        return $query->where('is_pinned', false);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('last_activity_at', 'desc');
    }

    public function scopePopular($query)
    {
        return $query->orderBy('replies_count', 'desc')
            ->orderBy('upvotes_count', 'desc');
    }

    public function getScoreAttribute(): int
    {
        return $this->upvotes_count - $this->downvotes_count;
    }

    public function incrementViews(): void
    {
        $this->increment('views_count');
    }
}
