<?php

namespace App\Models\Noccea\Learn;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    protected $fillable = [
        'title',
        'description',
        'long_description',
        'category',
        'level',
        'instructor',
        'price',
        'rating',
        'reviews',
        'students',
        'duration',
        'lessons',
        'image',
        'image_color',
        'slug',
        'is_featured',
    ];

    protected $appends = ['total_lessons', 'students_count', 'image_url'];

    public function modules(): HasMany
    {
        return $this->hasMany(CourseModule::class);
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(CourseEnrollment::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(CourseReview::class);
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(UserCertificate::class);
    }

    /**
     * Get total lessons count from all modules
     */
    public function getTotalLessonsAttribute(): int
    {
        if (!$this->relationLoaded('modules')) {
            return $this->lessons ?? 0;
        }

        return $this->modules->sum(function ($module) {
            return $module->relationLoaded('lessons') ? $module->lessons->count() : 0;
        });
    }

    /**
     * Get students count
     */
    public function getStudentsCountAttribute(): int
    {
        return $this->students ?? 0;
    }

    /**
     * Get course image URL
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->image && file_exists(public_path('images/courses/' . $this->image))) {
            return asset('images/courses/' . $this->image);
        }

        // Generate dynamic image URL based on course category
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->title) .
               '&size=400&background=' . $this->getColorCode() .
               '&color=fff&bold=true&format=svg';
    }

    /**
     * Get color code for image generation
     */
    private function getColorCode(): string
    {
        $colors = [
            'Web Development' => 'FF6B6B',
            'Mobile Development' => '4ECDC4',
            'Data Science' => 'FFE66D',
            'Cloud Computing' => '95E1D3',
            'DevOps' => 'F38181',
            'Blockchain' => 'AA96DA',
            'Design' => 'FCBAD3',
            'Digital Marketing' => 'FD79A8',
            'AI/ML' => '6C5CE7',
        ];

        return $colors[$this->category] ?? 'FF9800';
    }
}
