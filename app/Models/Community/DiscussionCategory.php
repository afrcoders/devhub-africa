<?php

namespace App\Models\Community;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DiscussionCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'order_index',
        'discussions_count',
        'replies_count',
        'last_activity_at'
    ];

    protected $casts = [
        'last_activity_at' => 'datetime',
    ];

    public function discussions(): HasMany
    {
        return $this->hasMany(Discussion::class, 'category_id');
    }

    public function latestDiscussions(): HasMany
    {
        return $this->discussions()
            ->with('user', 'category')
            ->orderBy('last_activity_at', 'desc');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order_index')->orderBy('name');
    }
}
