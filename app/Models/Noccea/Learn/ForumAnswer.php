<?php

namespace App\Models\Noccea\Learn;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ForumAnswer extends Model
{
    protected $table = 'forum_answers';

    protected $fillable = [
        'user_id',
        'question_id',
        'body',
        'votes',
        'is_accepted',
    ];

    protected $casts = [
        'is_accepted' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(ForumQuestion::class, 'question_id');
    }

    public function votes(): HasMany
    {
        return $this->hasMany(ForumVote::class, 'voteable_id')
            ->where('voteable_type', self::class);
    }

    public function userVote($userId): ?int
    {
        $vote = $this->votes()
            ->where('user_id', $userId)
            ->first();
        return $vote?->vote;
    }

    public function updateVoteCount()
    {
        $this->votes = $this->votes()->sum('vote');
        $this->save();
    }
}
