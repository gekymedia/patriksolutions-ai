<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\LessonProgress;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    public function show(Course $course, Lesson $lesson)
    {
        abort_unless($course->is_published && $lesson->course_id === $course->id, 404);
        abort_unless($course->isEnrolledBy(Auth::id()), 403);

        $lessons = $course->lessons;
        $completedLessonIds = LessonProgress::where('user_id', Auth::id())
            ->where('course_id', $course->id)
            ->whereNotNull('completed_at')
            ->pluck('lesson_id')
            ->all();

        $currentIndex = $lessons->search(fn ($l) => $l->id === $lesson->id);
        $prevLesson = $currentIndex > 0 ? $lessons[$currentIndex - 1] : null;
        $nextLesson = $currentIndex < $lessons->count() - 1 ? $lessons[$currentIndex + 1] : null;
        $isCompleted = in_array($lesson->id, $completedLessonIds);

        return view('lessons.show', compact(
            'course',
            'lesson',
            'lessons',
            'completedLessonIds',
            'prevLesson',
            'nextLesson',
            'isCompleted'
        ));
    }

    public function complete(Course $course, Lesson $lesson)
    {
        abort_unless($lesson->course_id === $course->id && $course->isEnrolledBy(Auth::id()), 403);

        LessonProgress::updateOrCreate(
            ['user_id' => Auth::id(), 'lesson_id' => $lesson->id],
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
