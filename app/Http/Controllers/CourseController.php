<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\LessonProgress;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::where('is_published', true)
            ->orderBy('sort_order')
            ->withCount('lessons')
            ->get();

        $enrolledIds = Auth::check()
            ? Enrollment::where('user_id', Auth::id())->pluck('course_id')->all()
            : [];

        // Which courses can the current viewer fully access (for lock badges).
        $user = Auth::user();
        $accessibleIds = $courses->filter(fn ($c) => $c->isAccessibleBy($user))->pluck('id')->all();

        return view('courses.index', compact('courses', 'enrolledIds', 'accessibleIds'));
    }

    public function show(Course $course)
    {
        abort_unless($course->is_published, 404);

        $course->load('lessons');

        $user = Auth::user();
        $canAccess = $course->isAccessibleBy($user);
        $upgradeMessage = $course->upgradeMessage();

        $isEnrolled = $user && $course->isEnrolledBy($user->id);
        $progressPercent = $user ? $course->progressPercentFor($user->id) : 0;
        $completedLessonIds = $user
            ? LessonProgress::where('user_id', $user->id)
                ->where('course_id', $course->id)
                ->whereNotNull('completed_at')
                ->pluck('lesson_id')
                ->all()
            : [];

        return view('courses.show', compact(
            'course',
            'isEnrolled',
            'progressPercent',
            'completedLessonIds',
            'canAccess',
            'upgradeMessage'
        ));
    }

    public function enroll(Course $course)
    {
        abort_unless($course->is_published, 404);

        $user = Auth::user();

        // Server-side gate: block enrollment if the user's plan can't access this course.
        if (! $course->isAccessibleBy($user)) {
            return redirect()->route('membership.index')
                ->with('upgrade_message', $course->upgradeMessage());
        }

        if ($course->isEnrolledBy($user->id)) {
            return redirect()->route('courses.show', $course)
                ->with('info', 'You are already enrolled in this course.');
        }

        Enrollment::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
        ]);

        $firstLesson = $course->lessons()->orderBy('sort_order')->first();

        if ($firstLesson) {
            return redirect()->route('lessons.show', [$course, $firstLesson])
                ->with('success', 'Welcome! Let\'s start your first lesson.');
        }

        return redirect()->route('courses.show', $course)
            ->with('success', 'You have successfully enrolled in this course.');
    }

    public function dashboard()
    {
        $user = Auth::user();

        $courses = Enrollment::where('user_id', $user->id)
            ->with(['course' => fn ($q) => $q->withCount('lessons')])
            ->get()
            ->map(function ($enrollment) use ($user) {
                $course = $enrollment->course;
                $course->progress_percent = $course->progressPercentFor($user->id);
                $course->completed_lessons = $course->completedLessonsFor($user->id);

                return $course;
            });

        return view('dashboard', compact('courses'));
    }
}
