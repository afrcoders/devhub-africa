<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ToolRating extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tool_slug',
        'rating',
    ];

    protected $casts = [
        'rating' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user who rated the tool
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope: Find ratings by tool slug
     */
    public function scopeByTool($query, $slug)
    {
        return $query->where('tool_slug', $slug);
    }

    /**
     * Scope: Find ratings by user
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Get average rating for a tool
     */
    public static function getAverageRating($toolSlug)
    {
        return self::byTool($toolSlug)->avg('rating') ?? 0;
    }

    /**
     * Get total rating count for a tool
     */
    public static function getTotalRatings($toolSlug)
    {
        return self::byTool($toolSlug)->count();
    }
}
