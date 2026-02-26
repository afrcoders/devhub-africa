<?php

namespace App\Models\Africoders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PressRelease extends Model
{
    use HasFactory;

    protected $table = 'africoders_press_releases';

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'author',
        'venture_id',
        'press_category',
        'meta_description',
        'meta_keywords',
        'featured',
        'published',
        'published_at',
    ];

    protected $casts = [
        'featured' => 'boolean',
        'published' => 'boolean',
        'published_at' => 'datetime',
    ];

    /**
     * Get the route key for model binding.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Scope to get only published press releases.
     */
    public function scopePublished($query)
    {
        return $query->where('published', true)->whereNotNull('published_at');
    }

    /**
     * Scope to get featured press releases.
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    /**
     * Get the venture associated with this press release.
     */
    public function venture()
    {
        return $this->belongsTo(Venture::class);
    }
}
