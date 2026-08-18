<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $courses = [
            [
                'name' => 'AI Fundamentals for Beginners',
                'slug' => 'ai-fundamentals',
                'description' => 'Learn what AI is, how it works, and how to use tools like ChatGPT and Claude effectively.',
                'level' => 'beginner',
                'sort_order' => 1,
                'ai_system_prompt' => 'You are an AI tutor teaching AI fundamentals to beginners. Explain concepts simply with practical examples.',
                'lessons' => [
                    ['title' => 'What is Artificial Intelligence?', 'description' => 'Understanding AI, machine learning, and how they differ from traditional software.', 'sort_order' => 1, 'duration_minutes' => 15, 'content' => "Welcome to AI Fundamentals!\n\nArtificial Intelligence (AI) refers to computer systems that perform tasks requiring human intelligence — understanding language, recognizing images, making decisions, and learning from data.\n\nYou've used AI if you've used Google Search, Siri, Netflix recommendations, or ChatGPT.\n\nKey takeaway: AI is pattern recognition at scale.", 'ai_lesson_prompt' => 'Use everyday examples. Avoid jargon.'],
                    ['title' => 'How to Use ChatGPT & Claude Effectively', 'description' => 'Master prompt engineering basics.', 'sort_order' => 2, 'duration_minutes' => 20, 'content' => "Prompt Engineering Basics\n\n1. Be Specific\n2. Give Context\n3. Ask for Step-by-Step\n4. Iterate\n5. Verify Important Info\n\nAI can make mistakes — always verify critical advice.", 'ai_lesson_prompt' => 'Help students write better prompts with examples.'],
                    ['title' => 'AI in Everyday Life', 'description' => 'Practical AI applications beyond chatbots.', 'sort_order' => 3, 'duration_minutes' => 20, 'content' => "AI is everywhere:\n\n• Email autocomplete\n• Photo editing\n• Voice assistants\n• Content recommendations\n\nStart with one tool. Master it. Then expand.", 'ai_lesson_prompt' => 'Focus on practical daily AI use cases.'],
                ],
            ],
            [
                'name' => 'AI for Business & Productivity',
                'slug' => 'ai-for-business',
                'description' => 'Automate workflows and boost productivity using AI tools in your business.',
                'level' => 'intermediate',
                'sort_order' => 2,
                'ai_system_prompt' => 'You teach business professionals how to use AI productively. Focus on workflows and ROI.',
                'lessons' => [
                    ['title' => 'Automating Repetitive Tasks', 'description' => 'Identify and automate time-consuming tasks with AI.', 'sort_order' => 1, 'duration_minutes' => 20, 'content' => "Audit your week for repetitive tasks.\n\nHigh-ROI automations:\n• Email drafting\n• Meeting summaries\n• FAQ responses\n\nStart with ONE task. Master it first.", 'ai_lesson_prompt' => 'Suggest workflows based on the student\'s role.'],
                    ['title' => 'AI Content Creation', 'description' => 'Create content faster with AI assistance.', 'sort_order' => 2, 'duration_minutes' => 25, 'content' => "AI excels at first drafts.\n\nWorkflow:\n1. Outline\n2. Draft section by section\n3. Edit for voice and accuracy\n4. Polish", 'ai_lesson_prompt' => 'Teach content creation prompt templates.'],
                ],
            ],
            [
                'name' => 'Advanced AI Strategies',
                'slug' => 'advanced-ai-strategies',
                'description' => 'Deep dive into AI agents, workflows, and building AI-powered systems.',
                'level' => 'advanced',
                'sort_order' => 3,
                'ai_system_prompt' => 'Advanced AI tutor. Discuss agents, automation pipelines, and strategic implementation.',
                'lessons' => [
                    ['title' => 'Building Multi-Tool AI Workflows', 'description' => 'Chain AI tools into automated pipelines.', 'sort_order' => 1, 'duration_minutes' => 30, 'content' => "Advanced users build pipelines:\n\n1. Trigger (form, email, schedule)\n2. AI processing step\n3. Human review\n4. Output action\n\nAlways include human oversight at critical steps.", 'ai_lesson_prompt' => 'Help architect workflows for the student\'s use case.'],
                ],
            ],
        ];

        foreach ($courses as $data) {
            $lessons = $data['lessons'];
            unset($data['lessons']);

            $course = Course::updateOrCreate(['slug' => $data['slug']], $data);

            foreach ($lessons as $lesson) {
                Lesson::updateOrCreate(
                    ['course_id' => $course->id, 'title' => $lesson['title']],
                    array_merge($lesson, ['content_type' => 'text'])
                );
            }
        }
    }
}
