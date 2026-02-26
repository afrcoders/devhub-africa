<?php

namespace App\Models\Help;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'help_articles';

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'category',
        'published',
        'views',
        'helpful_votes',
        'unhelpful_votes',
        'meta'
    ];

    protected $casts = [
        'published' => 'boolean',
        'views' => 'integer',
        'helpful_votes' => 'integer',
        'unhelpful_votes' => 'integer',
        'meta' => 'array'
    ];

    public function scopePublished($query)
    {
        return $query->where('published', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function incrementViews()
    {
        $this->increment('views');
    }

    public function incrementHelpfulVotes()
    {
        $this->increment('helpful_votes');
    }

    public function incrementUnhelpfulVotes()
    {
        $this->increment('unhelpful_votes');
    }
}
