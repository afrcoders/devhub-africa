<?php

namespace App\Models\Africoders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Venture extends Model
{
    use HasFactory;

    protected $table = 'africoders_ventures';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'content',
        'logo',
        'featured_image',
        'website_url',
        'mission',
        'vision',
        'status',
        'launch_year',
        'team_members',
        'tech_stack',
        'metrics',
        'meta_description',
        'meta_keywords',
        'featured',
        'published',
        'published_at',
        'order',
    ];

    protected $casts = [
        'featured' => 'boolean',
        'published' => 'boolean',
        'published_at' => 'datetime',
        'team_members' => 'json',
        'tech_stack' => 'json',
        'metrics' => 'json',
    ];

    /**
     * Get the route key for model binding.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Scope to get only published ventures.
     */
    public function scopePublished($query)
    {
        return $query->where('published', true)->whereNotNull('published_at');
    }

    /**
     * Scope to get featured ventures.
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    /**
     * Scope to get ventures by status.
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Get related press releases.
     */
    public function pressReleases()
    {
        return $this->hasMany(PressRelease::class);
    }
}
