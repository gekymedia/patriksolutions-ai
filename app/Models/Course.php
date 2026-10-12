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
        'required_plan',
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

    /**
     * The minimum membership tier required for full access: free | pro | elite.
     */
    public function requiredPlan(): string
    {
        return $this->required_plan ?? 'free';
    }

    public function isFreePlan(): bool
    {
        return $this->requiredPlan() === 'free';
    }

    /**
     * Can this user access the FULL content of this course?
     *   free  -> any signed-in user
     *   pro   -> active AI Member or AI Pro (or admin)
     *   elite -> active AI Pro (or admin)
     * Guests (null user) can never access full content (they get previews + descriptions).
     */
    public function isAccessibleBy(?User $user): bool
    {
        $required = $this->requiredPlan();

        if ($required === 'free') {
            return $user !== null;
        }

        if (! $user) {
            return false;
        }

        if ($user->isAdmin()) {
            return true;
        }

        if (! $user->hasActiveMembership()) {
            return false;
        }

        return match ($required) {
            'pro'   => $user->isPro(),   // pro or elite
            'elite' => $user->isElite(),
            default => false,
        };
    }

    /**
     * The upgrade prompt shown when a user cannot access this course.
     */
    public function upgradeMessage(): string
    {
        return match ($this->requiredPlan()) {
            'elite' => 'Upgrade to AI Pro — $49/month to unlock all courses, including Advanced AI Strategies.',
            'pro'   => 'Upgrade to AI Member — $19/month to unlock AI for Business & Productivity.',
            default => 'Create a free account to start this course.',
        };
    }

    /**
     * Human label for the required tier (for badges).
     */
    public function tierLabel(): string
    {
        return match ($this->requiredPlan()) {
            'elite' => 'AI Pro',
            'pro'   => 'AI Member',
            default => 'Free',
        };
    }
}
