<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lesson extends Model
{
    protected $fillable = [
        'course_id',
        'title',
        'description',
        'content',
        'content_type',
        'is_preview',
        'video_url',
        'sort_order',
        'duration_minutes',
        'ai_lesson_prompt',
    ];

    protected function casts(): array
    {
        return [
            'is_preview' => 'boolean',
        ];
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function isCompletedBy(int $userId): bool
    {
        return LessonProgress::where('user_id', $userId)
            ->where('lesson_id', $this->id)
            ->whereNotNull('completed_at')
            ->exists();
    }

    /**
     * Preview lessons are open to any signed-in user; otherwise full course access is required.
     */
    public function isAccessibleBy(?User $user): bool
    {
        return $this->is_preview || $this->course->isAccessibleBy($user);
    }
}
