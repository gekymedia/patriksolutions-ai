<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Course extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'level',
        'is_published',
        'ai_system_prompt',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Course $course) {
            if (empty($course->slug)) {
                $course->slug = Str::slug($course->name);
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class)->orderBy('sort_order');
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function totalLessons(): int
    {
        return $this->lessons()->count();
    }

    public function completedLessonsFor(int $userId): int
    {
        return LessonProgress::where('user_id', $userId)
            ->where('course_id', $this->id)
            ->whereNotNull('completed_at')
            ->count();
    }

    public function progressPercentFor(int $userId): int
    {
        $total = $this->totalLessons();
        if ($total === 0) {
            return 0;
        }

        return (int) round(($this->completedLessonsFor($userId) / $total) * 100);
    }

    public function isEnrolledBy(int $userId): bool
    {
        return Enrollment::where('user_id', $userId)
            ->where('course_id', $this->id)
            ->exists();
    }
}
