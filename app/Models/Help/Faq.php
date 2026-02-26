<?php

namespace App\Models\Help;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Faq extends Model
{
    use HasFactory;

    protected $table = 'help_faqs';

    protected $fillable = [
        'question',
        'answer',
        'category',
        'published',
        'order',
        'helpful_votes',
        'unhelpful_votes',
        'meta'
    ];

    protected $casts = [
        'published' => 'boolean',
        'order' => 'integer',
        'helpful_votes' => 'integer',
        'unhelpful_votes' => 'integer',
        'meta' => 'array'
    ];

    // Scopes
    public function scopeActive(Builder $query)
    {
        return $query->where('published', true);
    }

    public function scopeByCategory(Builder $query, $category)
    {
        return $query->where('category', $category);
    }

    // Accessors
    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('M j, Y');
    }
}
