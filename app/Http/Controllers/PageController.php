<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function faq()
    {
        return view('pages.faq', ['faqs' => self::faqs()]);
    }

    public function terms()
    {
        return view('pages.terms');
    }

    public function privacy()
    {
        return view('pages.privacy');
    }

    public function refund()
    {
        return view('pages.refund');
    }

    /**
     * Plain-text /llms.txt so answer engines (ChatGPT, Perplexity, Google AI)
     * can understand and cite the site. (AEO item A4.)
     */
    public function llms()
    {
        return response()
            ->view('pages.llms')
            ->header('Content-Type', 'text/plain; charset=utf-8');
    }

    /**
     * Single source of truth for FAQs — rendered on the FAQ page AND emitted as
     * FAQPage structured data. Each answer is a direct 40–60 word answer (AEO).
     *
     * @return array<int, array{q: string, a: string}>
     */
    public static function faqs(): array
    {
        $member = '$' . config('platform.prices.pro');
        $pro = '$' . config('platform.prices.elite');

        return [
            [
                'q' => 'How can I make money with AI in Ghana or the diaspora?',
                'a' => 'You make money with AI by using it to deliver a service faster or better than before — content, admin, customer support, research, bookkeeping, design and more. Patrik Solutions AI teaches these skills step by step so you can earn as a freelancer, in your job, or in your own business, wherever you live.',
            ],
            [
                'q' => 'Do I need coding or technical experience to start?',
                'a' => 'No. The AI Fundamentals course is beginner-friendly and assumes zero coding. You learn through plain-English lessons and hands-on practice with everyday AI tools. Optional coding is clearly marked in the advanced track, so you can go as technical as you want — or never touch code at all.',
            ],
            [
                'q' => 'What does it cost, and is there a free option?',
                'a' => "Yes — the AI Fundamentals course is free to enroll once you create an account. AI Member ({$member}/month) unlocks AI for Business & Productivity and the AI tutor. AI Pro ({$pro}/month) unlocks every course, including Advanced AI Strategies, plus priority support and coaching.",
            ],
            [
                'q' => 'What is the difference between AI Member and AI Pro?',
                'a' => "AI Member ({$member}/month) gives you the Fundamentals and Business courses, the AI tutor on every lesson, progress tracking and a monthly live Q&A. AI Pro ({$pro}/month) adds the Advanced AI Strategies course, more daily tutor questions, priority responses, a monthly 1-on-1 coaching call and early access to new courses.",
            ],
            [
                'q' => 'Who teaches the courses?',
                'a' => config('platform.instructor.name') . ', the founder of Patrik Solutions, teaches every course. He is an AIGP-certified AI engineer and instructor who builds real AI agents and automations, and a personal financial advisor. The courses combine practical AI skill-building with a clear focus on using those skills to earn.',
            ],
            [
                'q' => 'Can I get a refund if it is not for me?',
                'a' => 'Yes. Paid plans come with a ' . config('platform.legal.refund_days') . '-day money-back guarantee on your first payment — email us within ' . config('platform.legal.refund_days') . ' days of starting a paid plan and we will refund it. You can also cancel anytime and keep access until the end of your billing period.',
            ],
            [
                'q' => 'How do the lessons and AI tutor work?',
                'a' => 'Each course is a set of self-paced lessons you can take on any device, with your progress saved automatically. On paid plans, an AI tutor sits on every lesson so you can ask questions and get instant, lesson-specific help — like having an instructor available while you learn.',
            ],
            [
                'q' => 'Which payment methods can I use?',
                'a' => 'Card payments in US dollars are available now through Stripe, which works for learners worldwide. Mobile Money and cedi (GHS) pricing for Ghana are planned so local learners can pay the easiest way for them. Check the membership page for the current options.',
            ],
        ];
    }
}
