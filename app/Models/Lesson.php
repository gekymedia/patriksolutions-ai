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
        'video_url',
        'sort_order',
        'duration_minutes',
        'ai_lesson_prompt',
    ];

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
}
