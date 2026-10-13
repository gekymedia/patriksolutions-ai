<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Idempotent: courses are matched by slug and lessons by (course_id, sort_order),
     * so running this repeatedly updates content in place and preserves progress.
     * Lesson bodies are loaded from Markdown files in database/content/{slug}/NN.md.
     */
    public function run(): void
    {
        foreach ($this->courses() as $data) {
            $lessons = $data['lessons'];
            unset($data['lessons']);

            $course = Course::updateOrCreate(['slug' => $data['slug']], $data);

            foreach ($lessons as $lesson) {
                $lesson['content'] = $this->content($data['slug'], $lesson['sort_order']);
                $lesson['content_type'] = 'text';

                Lesson::updateOrCreate(
                    ['course_id' => $course->id, 'sort_order' => $lesson['sort_order']],
                    array_merge($lesson, ['course_id' => $course->id])
                );
            }

            // Remove any leftover lessons beyond the defined set (cascades lesson_progress).
            Lesson::where('course_id', $course->id)
                ->where('sort_order', '>', count($lessons))
                ->delete();
        }
    }

    private function content(string $slug, int $order): string
    {
        $path = database_path('content/'.$slug.'/'.sprintf('%02d', $order).'.md');

        return is_file($path) ? (string) file_get_contents($path) : '';
    }

    private function courses(): array
    {
        return [
            // ---------- Course 1 — FREE ----------
            [
                'name' => 'AI Fundamentals for Beginners',
                'slug' => 'ai-fundamentals',
                'description' => 'Go from zero to confidently using AI. Learn what AI and generative AI really are, what they can and cannot do, how to talk to assistants like ChatGPT and Claude, how to write great prompts, and how to use AI safely in everyday life. Ends with a hands-on project. No experience needed.',
                'level' => 'beginner',
                'required_plan' => 'free',
                'is_published' => true,
                'sort_order' => 1,
                'ai_system_prompt' => "You are the AI tutor for 'AI Fundamentals for Beginners' on Patrik Solutions AI. Explain simply, avoid jargon, use everyday examples, and be friendly and encouraging. Focus on the current lesson. Do not reference services outside this learning platform.",
                'lessons' => [
                    ['sort_order' => 1, 'is_preview' => true, 'duration_minutes' => 55, 'title' => 'What AI (and Generative AI) Actually Is', 'description' => 'The simple mental model that makes everything else click.'],
                    ['sort_order' => 2, 'is_preview' => false, 'duration_minutes' => 55, 'title' => 'What AI Can and Cannot Do', 'description' => "AI's real strengths, its limits, and the 'hallucination' problem — so you never get burned."],
                    ['sort_order' => 3, 'is_preview' => false, 'duration_minutes' => 60, 'title' => 'Getting Started With AI Assistants', 'description' => 'Pick a tool, set it up, and have your first real conversation.'],
                    ['sort_order' => 4, 'is_preview' => false, 'duration_minutes' => 60, 'title' => 'Writing Clear Prompts', 'description' => 'The one skill that turns frustrating AI into genuinely useful AI.'],
                    ['sort_order' => 5, 'is_preview' => false, 'duration_minutes' => 70, 'title' => 'Everyday Uses, Fact-Checking, Privacy & Responsible Use', 'description' => 'Use AI for real tasks while checking facts and protecting your privacy — plus your final project.'],
                ],
            ],

            // ---------- Course 2 — AI MEMBER (pro) ----------
            [
                'name' => 'AI for Business & Productivity',
                'slug' => 'ai-for-business',
                'description' => 'Put AI to work. Draft emails, proposals and reports, create marketing and social content, speed up customer service and research, and build repeatable AI workflows — then build and document your own. Intermediate; best taken after AI Fundamentals.',
                'level' => 'intermediate',
                'required_plan' => 'pro',
                'is_published' => true,
                'sort_order' => 2,
                'ai_system_prompt' => "You are the AI tutor for 'AI for Business & Productivity' on Patrik Solutions AI. Give practical, business-focused help with concrete examples (small business, consulting, retail, home care, content creation). Be ROI-minded and specific. Keep privacy in mind. Focus on the current lesson.",
                'lessons' => [
                    ['sort_order' => 1, 'is_preview' => true, 'duration_minutes' => 70, 'title' => 'Finding Your AI Opportunities', 'description' => 'Spot the tasks where AI saves the most time — and which to leave alone.'],
                    ['sort_order' => 2, 'is_preview' => false, 'duration_minutes' => 85, 'title' => 'Business Writing With AI', 'description' => 'Draft emails, proposals, and reports in minutes — in your own voice.'],
                    ['sort_order' => 3, 'is_preview' => false, 'duration_minutes' => 85, 'title' => 'Marketing & Social Media With AI', 'description' => 'Create content and a simple plan that keep you posting without burnout.'],
                    ['sort_order' => 4, 'is_preview' => false, 'duration_minutes' => 75, 'title' => 'Customer Service With AI', 'description' => 'Faster, kinder, consistent replies — with the privacy care customer data needs.'],
                    ['sort_order' => 5, 'is_preview' => false, 'duration_minutes' => 80, 'title' => 'Research & Organizing Business Information', 'description' => 'Research faster, summarize long documents, and turn mess into clean structure.'],
                    ['sort_order' => 6, 'is_preview' => false, 'duration_minutes' => 90, 'title' => 'Repeatable Workflows & Simple Automations', 'description' => 'Turn your best prompts into reusable workflows — and build your own (final project).'],
                ],
            ],

            // ---------- Course 3 — AI PRO (elite) ----------
            [
                'name' => 'Advanced AI Strategies',
                'slug' => 'advanced-ai-strategies',
                'description' => 'Build with AI. Advanced prompting systems, multi-step workflows, custom AI assistants and agents, connecting AI to your own documents (RAG), integrations and APIs, quality evaluation, governance and security — plus a capstone where you ship a working AI solution. No-code friendly; coding optional.',
                'level' => 'advanced',
                'required_plan' => 'elite',
                'is_published' => true,
                'sort_order' => 3,
                'ai_system_prompt' => "You are the AI tutor for 'Advanced AI Strategies' on Patrik Solutions AI. Help with advanced prompting, workflows, assistants/agents, RAG, APIs, evaluation, governance and launching AI solutions. Be precise, distinguish no-code from optional coding, and always include safety/guardrails. Focus on the current lesson.",
                'lessons' => [
                    ['sort_order' => 1, 'is_preview' => true, 'duration_minutes' => 90, 'title' => 'Advanced Prompting & Reusable Prompt Systems', 'description' => 'Pro techniques, reliable templates, and shareable prompt libraries.'],
                    ['sort_order' => 2, 'is_preview' => false, 'duration_minutes' => 90, 'title' => 'Multi-Step Workflows & Prompt Chaining', 'description' => 'Chain focused steps into robust workflows with checks and branching.'],
                    ['sort_order' => 3, 'is_preview' => false, 'duration_minutes' => 100, 'title' => 'Building AI Assistants & Agents', 'description' => 'Build a custom AI assistant (no code) and understand what agents really do.'],
                    ['sort_order' => 4, 'is_preview' => false, 'duration_minutes' => 95, 'title' => 'Connecting AI to Your Documents (an intro to RAG)', 'description' => 'Make AI answer from YOUR documents — an accessible intro to RAG.'],
                    ['sort_order' => 5, 'is_preview' => false, 'duration_minutes' => 100, 'title' => 'Integrations, APIs & Automation', 'description' => 'Wire AI into your other tools and build a real no-code automation.'],
                    ['sort_order' => 6, 'is_preview' => false, 'duration_minutes' => 85, 'title' => 'Evaluating Quality & Troubleshooting Failures', 'description' => "Define 'good', test with a simple eval, and fix the common failure modes."],
                    ['sort_order' => 7, 'is_preview' => false, 'duration_minutes' => 85, 'title' => 'AI Governance, Privacy, Security & Human Oversight', 'description' => 'The rules that keep your AI safe, legal, and trustworthy — including prompt injection.'],
                    ['sort_order' => 8, 'is_preview' => false, 'duration_minutes' => 120, 'title' => 'Planning, Costing & Launching an AI Solution', 'description' => 'Scope, cost, launch — and build your capstone AI solution.'],
                ],
            ],
        ];
    }
}
