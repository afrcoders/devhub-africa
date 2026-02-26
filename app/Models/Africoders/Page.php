<?php

namespace App\Models\Africoders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Page extends Model
{
    use HasFactory;

    protected $table = 'africoders_pages';

    protected $fillable = [
        'title',
        'slug',
        'content',
        'meta_description',
        'meta_keywords',
        'featured_image',
        'published',
        'published_at',
        'page_type',
    ];

    protected $casts = [
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
     * Scope to get only published pages.
     */
    public function scopePublished($query)
    {
        return $query->where('published', true)->whereNotNull('published_at');
    }

    /**
     * Scope to get pages by type.
     */
    public function scopeByType($query, $type)
    {
        return $query->where('page_type', $type);
    }
}
