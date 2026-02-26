<?php

namespace App\Models\Community;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DiscussionReply extends Model
{
    use HasFactory;

    protected $fillable = [
        'discussion_id',
        'user_id',
        'parent_id',
        'body',
        'upvotes_count',
        'downvotes_count',
        'is_best_answer'
    ];

    protected $casts = [
        'is_best_answer' => 'boolean',
    ];

    public function discussion(): BelongsTo
    {
        return $this->belongsTo(Discussion::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(DiscussionReply::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(DiscussionReply::class, 'parent_id');
    }

    public function votes(): HasMany
    {
        return $this->hasMany(DiscussionVote::class, 'votable_id')
            ->where('votable_type', 'reply');
    }

    public function getScoreAttribute(): int
    {
        return $this->upvotes_count - $this->downvotes_count;
    }

    public function markAsBestAnswer(): void
    {
        // Remove best answer from other replies in this discussion
        $this->discussion->replies()->update(['is_best_answer' => false]);

        // Mark this as best answer
        $this->update(['is_best_answer' => true]);

        // Update discussion's best_reply_id
        $this->discussion->update(['best_reply_id' => $this->id]);
    }
}
