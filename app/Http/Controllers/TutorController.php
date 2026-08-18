<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TutorController extends Controller
{
    public function chat(Request $request, Course $course, Lesson $lesson)
    {
        abort_unless(
            $lesson->course_id === $course->id && $course->isEnrolledBy(Auth::id()),
            403
        );

        $request->validate([
            'message' => 'required|string|max:1000',
            'history' => 'nullable|array|max:10',
        ]);

        $user = Auth::user();
        $rateKey = "tutor_{$user->id}_" . now()->format('Y-m-d');
        $limit = $user->dailyTutorLimit();
        $count = Cache::get($rateKey, 0);

        if ($count >= $limit) {
            return response()->json([
                'success' => false,
                'message' => 'Daily AI tutor limit reached. Try again tomorrow.',
            ], 429);
        }

        Cache::put($rateKey, $count + 1, now()->endOfDay());

        $messages = [];
        foreach (array_slice($request->input('history', []), -8) as $item) {
            $messages[] = ['role' => $item['role'], 'content' => $item['content']];
        }
        $messages[] = ['role' => 'user', 'content' => $request->input('message')];

        try {
            $response = Http::withHeaders([
                'x-api-key' => config('services.anthropic.api_key'),
                'anthropic-version' => '2023-06-01',
                'Content-Type' => 'application/json',
            ])->timeout(30)->post('https://api.anthropic.com/v1/messages', [
                'model' => 'claude-sonnet-4-20250514',
                'max_tokens' => 1000,
                'system' => $this->systemPrompt($course, $lesson),
                'messages' => $messages,
            ]);

            if ($response->failed()) {
                Log::error('AI tutor API error', ['status' => $response->status()]);
                return response()->json(['success' => false, 'message' => 'AI tutor is temporarily unavailable.'], 503);
            }

            return response()->json([
                'success' => true,
                'reply' => $response->json('content.0.text') ?? 'Sorry, I could not generate a response.',
                'remaining' => $limit - $count - 1,
            ]);
        } catch (\Exception $e) {
            Log::error('AI tutor error', ['message' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Something went wrong.'], 500);
        }
    }

    private function systemPrompt(Course $course, Lesson $lesson): string
    {
        $base = $course->ai_system_prompt ?: <<<PROMPT
You are the AI Tutor for Patrik Solutions AI courses. Help students understand AI concepts clearly with practical examples.
Be encouraging, concise, and focus on the current lesson. Keep responses under 200 words unless a detailed explanation is needed.
Do not mention unrelated services, financial tools, or websites outside this AI learning platform.
PROMPT;

        return $base . "\n\nCourse: {$course->name}\nLesson: {$lesson->title}\nOverview: {$lesson->description}"
            . ($lesson->ai_lesson_prompt ? "\nGuidance: {$lesson->ai_lesson_prompt}" : '');
    }
}
