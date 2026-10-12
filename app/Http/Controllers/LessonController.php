<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\LessonProgress;
use Illuminate\Support\Facades\Auth;
use League\CommonMark\GithubFlavoredMarkdownConverter;

class LessonController extends Controller
{
    public function show(Course $course, Lesson $lesson)
    {
        abort_unless($course->is_published && $lesson->course_id === $course->id, 404);

        $user = Auth::user();
        $hasFullAccess = $course->isAccessibleBy($user);

        // Server-side gate: preview lessons are open to any signed-in user;
        // every other lesson requires full course access for the user's tier.
        if (! $lesson->is_preview && ! $hasFullAccess) {
            return redirect()->route('membership.index')
                ->with('upgrade_message', $course->upgradeMessage());
        }

        // Auto-enroll eligible users the first time they open a lesson, so progress is tracked.
        if ($hasFullAccess && ! $course->isEnrolledBy($user->id)) {
            Enrollment::firstOrCreate(['user_id' => $user->id, 'course_id' => $course->id]);
        }

        $lessons = $course->lessons;
        $completedLessonIds = LessonProgress::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->whereNotNull('completed_at')
            ->pluck('lesson_id')
            ->all();

        $currentIndex = $lessons->search(fn ($l) => $l->id === $lesson->id);
        $prevLesson = $currentIndex > 0 ? $lessons[$currentIndex - 1] : null;
        $nextLesson = $currentIndex < $lessons->count() - 1 ? $lessons[$currentIndex + 1] : null;
        $isCompleted = in_array($lesson->id, $completedLessonIds);

        // Lesson content is authored in Markdown; render to HTML (GitHub-flavored for tables, etc.).
        $contentHtml = $lesson->content
            ? (new GithubFlavoredMarkdownConverter())->convert($lesson->content)->getContent()
            : '';

        return view('lessons.show', compact(
            'course',
            'lesson',
            'lessons',
            'completedLessonIds',
            'prevLesson',
            'nextLesson',
            'isCompleted',
            'contentHtml',
            'hasFullAccess'
        ));
    }

    public function complete(Course $course, Lesson $lesson)
    {
        $user = Auth::user();

        abort_unless($lesson->course_id === $course->id, 404);
        // Only users with full course access can record progress.
        abort_unless($course->isAccessibleBy($user), 403);

        LessonProgress::updateOrCreate(
            ['user_id' => $user->id, 'lesson_id' => $lesson->id],
            ['course_id' => $course->id, 'completed_at' => now()]
        );

        $nextLesson = $course->lessons()
            ->where('sort_order', '>', $lesson->sort_order)
            ->orderBy('sort_order')
            ->first();

        if ($nextLesson) {
            return redirect()->route('lessons.show', [$course, $nextLesson])
                ->with('success', 'Lesson completed! Moving to the next lesson.');
        }

        return redirect()->route('courses.show', $course)
            ->with('success', 'Congratulations! You completed this course.');
    }
}
