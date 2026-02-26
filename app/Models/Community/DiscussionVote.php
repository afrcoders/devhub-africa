<?php

namespace App\Models\Community;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class DiscussionVote extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'votable_type',
        'votable_id',
        'vote_type'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function votable(): MorphTo
    {
        return $this->morphTo();
    }

    public static function toggle(User $user, $model, string $voteType): array
    {
        $votableType = $model instanceof Discussion ? 'discussion' : 'reply';

        $existingVote = static::where([
            'user_id' => $user->id,
            'votable_type' => $votableType,
            'votable_id' => $model->id,
        ])->first();

        if ($existingVote) {
            if ($existingVote->vote_type === $voteType) {
                // Remove vote if clicking same vote type
                $existingVote->delete();
                static::updateCounts($model, $voteType, -1);
                return ['action' => 'removed', 'vote_type' => $voteType];
            } else {
                // Change vote type
                static::updateCounts($model, $existingVote->vote_type, -1);
                $existingVote->update(['vote_type' => $voteType]);
                static::updateCounts($model, $voteType, 1);
                return ['action' => 'changed', 'vote_type' => $voteType];
            }
        } else {
            // Create new vote
            static::create([
                'user_id' => $user->id,
                'votable_type' => $votableType,
                'votable_id' => $model->id,
                'vote_type' => $voteType
            ]);
            static::updateCounts($model, $voteType, 1);
            return ['action' => 'added', 'vote_type' => $voteType];
        }
    }

    private static function updateCounts($model, string $voteType, int $change): void
    {
        $column = $voteType === 'upvote' ? 'upvotes_count' : 'downvotes_count';
        $model->increment($column, $change);
    }
}
