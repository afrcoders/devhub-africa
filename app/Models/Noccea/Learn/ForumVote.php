<?php

namespace App\Models\Noccea\Learn;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ForumVote extends Model
{
    protected $fillable = [
        'user_id',
        'voteable_id',
        'voteable_type',
        'vote',
    ];

    protected $casts = [
        'vote' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }

    public function voteable(): MorphTo
    {
        return $this->morphTo();
    }
}
