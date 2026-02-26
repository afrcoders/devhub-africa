<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KortexTool extends Model
{
    use HasFactory;

    protected $table = 'kortextools';

    protected $fillable = [
        'slug',
        'name',
        'category',
        'description',
        'icon',
        'meta_title',
        'meta_description',
        'popularity',
        'rating',
        'rating_count',
        'is_active',
        'properties',
    ];

    protected $casts = [
        'properties' => 'array',
        'is_active' => 'boolean',
        'popularity' => 'integer',
        'rating' => 'decimal:1',
        'rating_count' => 'integer',
    ];

    /**
     * Scope to get only active tools
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get tools by category
     */
    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Get tools grouped by category
     */
    public static function getByCategory($activeOnly = true)
    {
        $query = static::query();

        if ($activeOnly) {
            $query->active();
        }

        return $query->orderBy('category')
                    ->orderByDesc('popularity')
                    ->orderByDesc('rating')
                    ->get()
                    ->groupBy('category');
    }

    /**
     * Get all categories
     */
    public static function getCategories($activeOnly = true)
    {
        $query = static::query();

        if ($activeOnly) {
            $query->active();
        }

        return $query->distinct('category')
                    ->orderBy('category')
                    ->pluck('category');
    }
}
