<?php

namespace App\Models\Help;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class LegalDocument extends Model
{
    use HasFactory;

    protected $table = 'help_legal_documents';

    protected $fillable = [
        'title',
        'slug',
        'content',
        'version',
        'status',
        'effective_date',
        'meta'
    ];

    protected $casts = [
        'status' => 'string',
        'effective_date' => 'datetime',
        'meta' => 'array'
    ];

    // Scopes
    public function scopeActive(Builder $query)
    {
        return $query->where('status', 'active');
    }

    public function scopeBySlug(Builder $query, $slug)
    {
        return $query->where('slug', $slug);
    }

    // Accessors
    public function getFormattedEffectiveDateAttribute()
    {
        return $this->effective_date ? $this->effective_date->format('F j, Y') : null;
    }

    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('M j, Y');
    }
}
