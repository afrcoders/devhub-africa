<?php

namespace App\Models\Business;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Business extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'description',
        'website',
        'phone',
        'email',
        'address',
        'city',
        'country',
        'category_id',
        'logo',
        'cover_image',
        'is_featured',
        'is_verified',
        'status',
        'views_count',
        'rating',
        'reviews_count'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_verified' => 'boolean',
        'rating' => 'decimal:2'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($business) {
            if (!$business->slug) {
                $business->slug = Str::slug($business->name);
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(BusinessCategory::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(BusinessReview::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function incrementViews(): void
    {
        $this->increment('views_count');
    }

    /**
     * Calculate and update the business rating based on approved reviews
     */
    public function updateRating(): void
    {
        $approvedReviews = $this->reviews()->approved();
        $averageRating = $approvedReviews->avg('rating') ?: 0;
        $reviewsCount = $approvedReviews->count();

        $this->update([
            'rating' => round($averageRating, 2),
            'reviews_count' => $reviewsCount
        ]);
    }

    /**
     * Get the average rating for display purposes
     */
    public function getAverageRatingAttribute(): float
    {
        return (float) $this->rating;
    }

    /**
     * Check if user can review this business
     */
    public function canBeReviewedBy(?User $user): bool
    {
        if (!$user) {
            return false;
        }

        // User cannot review their own business
        if ($this->user_id === $user->id) {
            return false;
        }

        // Check if user has already reviewed this business
        return !$this->reviews()
            ->where('user_id', $user->id)
            ->exists();
    }
}
