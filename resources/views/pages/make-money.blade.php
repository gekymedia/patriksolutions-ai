@extends('layouts.platform')
@section('title', 'Make Money With AI — Learn the Skills That Pay | ' . config('platform.name'))
@section('meta_description', 'Learn to make money with AI — the real skills, a clear learning path, free guides and a free starter course. Built for beginners in Ghana, the diaspora and worldwide.')
@section('canonical_url', route('make-money'))

@php
    $priceMember = config('platform.prices.pro');
    $pricePro = config('platform.prices.elite');
    $refundDays = config('platform.legal.refund_days');
    $guides = config('guides', []);
    $featuredGuides = ['make-money-with-ai-ghana','make-money-with-ai-diaspora','ai-side-hustles-no-coding','start-ai-freelancing-service'];
    $startUrl = auth()->check() ? route('courses.index') : route('register');
@endphp

@push('structured_data')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@graph": [
        {
            "@type": "WebPage",
            "name": "Make Money With AI",
            "url": "{{ route('make-money') }}",
            "description": "Learn to make money with AI through a clear, practical learning path and free resources.",
            "isPartOf": { "@type": "WebSite", "name": "{{ config('platform.name') }}", "url": "{{ config('platform.url') }}" }
        },
        {
            "@type": "FAQPage",
            "mainEntity": [
                @foreach($faqs as $faq)
                { "@type": "Question", "name": @json($faq['q']), "acceptedAnswer": { "@type": "Answer", "text": @json($faq['a']) } }@if(!$loop->last),@endif
                @endforeach
            ]
        },
        {
            "@type": "BreadcrumbList",
            "itemListElement": [
                { "@type": "ListItem", "position": 1, "name": "Home", "item": "{{ route('home') }}" },
                { "@type": "ListItem", "position": 2, "name": "Make Money With AI", "item": "{{ route('make-money') }}" }
            ]
        }
    ]
}
</script>
@endpush

@section('content')
{{-- HERO --}}
<section class="ai-hero">
    <div class="container ai-hero-content">
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                <div class="ai-badge"><i class="fas fa-sack-dollar"></i> The Make Money With AI track</div>
                <h1>Make Money With AI</h1>
                <p>
                    AI is the biggest leverage tool of our time. Learn to use it to earn more, work faster, and build
                    skills that pay — as a freelancer, in your job, or in your own business. Start free, no experience needed.
                </p>
                <div class="d-flex flex-wrap align-items-center gap-3 mt-4">
                    <a href="{{ $startUrl }}" class="ai-btn ai-btn-primary btn-lg"><i class="fas fa-play"></i> Start the Free AI Course</a>
                    <a href="{{ route('lead.show') }}" class="text-decoration-none" style="color: rgba(255,255,255,0.85); font-weight: 600;">
                        Get the free AI Income Kit <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- HONEST PROMISE --}}
<section class="ai-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9 text-center">
                <h2 class="ai-section-title">The honest truth about making money with AI</h2>
                <p class="text-muted" style="font-size: 1.1rem;">
                    AI is not a magic money button. You earn when you use AI to deliver <strong>real value</strong> —
                    faster or better than before. The people who win aren't chasing shortcuts; they learn one genuine
                    skill and use AI to do it exceptionally well. That's exactly what this track teaches.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- 3 WAYS TO EARN --}}
<section class="ai-section" style="background:#fff;border-top:1px solid var(--ai-border);border-bottom:1px solid var(--ai-border);">
    <div class="container">
        <h2 class="ai-section-title">Three ways to earn with AI</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="ai-card p-4 h-100">
                    <i class="fas fa-rocket fa-lg mb-2" style="color: var(--ai-primary);"></i>
                    <h3 class="h5 fw-bold">Earn on the side</h3>
                    <p class="text-muted mb-0 small">Offer an AI-powered service — writing, design, social media, admin — as a freelancer and charge for faster, better work.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="ai-card p-4 h-100">
                    <i class="fas fa-chart-line fa-lg mb-2" style="color: var(--ai-primary);"></i>
                    <h3 class="h5 fw-bold">Earn more at work</h3>
                    <p class="text-muted mb-0 small">Get more done in less time, take on bigger work, and become the person on your team who truly "gets AI".</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="ai-card p-4 h-100">
                    <i class="fas fa-store fa-lg mb-2" style="color: var(--ai-primary);"></i>
                    <h3 class="h5 fw-bold">Earn in your business</h3>
                    <p class="text-muted mb-0 small">Automate the slow, repetitive tasks so you can serve more customers without adding more hours.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- LEARNING PATH --}}
<section class="ai-section">
    <div class="container">
        <h2 class="ai-section-title">Your learning path</h2>
        <p class="ai-section-subtitle">Start free, then go as deep as you want.</p>
        <div class="row g-4">
            @foreach($courses as $i => $course)
                <div class="col-lg-4">
                    <div class="ai-card p-4 h-100">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="badge" style="background: var(--ai-gradient);">Step {{ $i + 1 }}</span>
                            @if($course->isFreePlan())
                                <span class="badge bg-success">Free</span>
                            @else
                                <span class="badge bg-secondary">{{ $course->tierLabel() }}</span>
                            @endif
                        </div>
                        <h3 class="h5 fw-bold">{{ $course->name }}</h3>
                        <p class="text-muted small">{{ Str::limit($course->description, 110) }}</p>
                        <p class="small fw-semibold mb-2">
                            @if($course->isFreePlan())
                                <span class="text-success">Free to enroll</span>
                            @elseif($course->requiredPlan() === 'pro')
                                AI Member · ${{ $priceMember }}/mo
                            @else
                                AI Pro · ${{ $pricePro }}/mo
                            @endif
                            · {{ $course->lessons_count }} lessons
                        </p>
                        <a href="{{ route('courses.show', $course) }}" class="ai-btn ai-btn-dark w-100 justify-content-center">View course</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- FREE GUIDES --}}
<section class="ai-section" style="background:#fff;border-top:1px solid var(--ai-border);">
    <div class="container">
        <h2 class="ai-section-title">Free guides to get started</h2>
        <div class="row g-3">
            @foreach($featuredGuides as $slug)
                @if(isset($guides[$slug]))
                    <div class="col-md-6">
                        <a href="{{ route('guides.show', $slug) }}" class="ai-card p-3 h-100 d-flex align-items-center gap-3 text-decoration-none" style="color:inherit;">
                            <i class="fas fa-file-lines" style="color: var(--ai-primary);"></i>
                            <span class="fw-semibold">{{ $guides[$slug]['title'] }}</span>
                        </a>
                    </div>
                @endif
            @endforeach
        </div>
        <div class="text-center mt-3">
            <a href="{{ route('guides.index') }}" class="fw-semibold text-decoration-none" style="color: var(--ai-primary);">See all free guides <i class="fas fa-arrow-right ms-1"></i></a>
        </div>
    </div>
</section>

{{-- LEAD MAGNET --}}
<section class="ai-section">
    <div class="container">
        <div class="ai-card p-4 p-lg-5" style="background: var(--ai-gradient); color:#fff;">
            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <h2 class="fw-bold mb-2" style="color:#fff;">{{ config('platform.lead_magnet.title') }}</h2>
                    <p class="mb-0" style="color: rgba(255,255,255,0.9);">Grab the free kit: the top AI skills, a prompt framework, and a 7-day plan to land your first result.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="{{ route('lead.show') }}" class="ai-btn" style="background:#fff;color:var(--ai-primary);font-weight:700;"><i class="fas fa-download"></i> Get the free kit</a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- GUARANTEE --}}
<section class="ai-section" style="background:#fff;border-top:1px solid var(--ai-border);">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <i class="fas fa-shield-heart mb-2" style="color: var(--ai-primary); font-size: 2rem;"></i>
                <h2 class="h4 fw-bold">Try it risk-free</h2>
                <p class="text-muted">Start free with no card. On any paid plan you're covered by a <strong>{{ $refundDays }}-day money-back guarantee</strong>, and you can cancel anytime. See our <a href="{{ route('refund') }}">Refund Policy</a>.</p>
            </div>
        </div>
    </div>
</section>

{{-- FAQ --}}
<section class="ai-section">
    <div class="container">
        <h2 class="ai-section-title">Questions about making money with AI</h2>
        <div class="row justify-content-center">
            <div class="col-lg-9">
                @foreach($faqs as $faq)
                    <div class="ai-card p-4 mb-3">
                        <h3 class="h6 fw-bold mb-2">{{ $faq['q'] }}</h3>
                        <p class="text-muted mb-0 small">{{ $faq['a'] }}</p>
                    </div>
                @endforeach
                <div class="text-center mt-3">
                    <a href="{{ route('faq') }}" class="ai-btn ai-btn-dark"><i class="fas fa-circle-question"></i> See all FAQs</a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- FINAL CTA --}}
<section class="ai-hero" style="padding: 4rem 0;">
    <div class="container ai-hero-content text-center">
        <h2 class="fw-bold mb-3" style="font-size: 2rem;">Start making money with AI today</h2>
        <p class="mx-auto mb-4" style="max-width: 540px;">Create a free account and begin the AI Fundamentals course — no card required.</p>
        <a href="{{ $startUrl }}" class="ai-btn ai-btn-primary btn-lg"><i class="fas fa-play"></i> Start the Free AI Course</a>
    </div>
</section>
@endsection
