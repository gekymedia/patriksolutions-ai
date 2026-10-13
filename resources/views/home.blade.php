@extends('layouts.platform')
@section('title', 'Make Money With AI — Courses for Ghana, the Diaspora & Beyond')
@section('meta_description', 'Learn to make money with AI through practical, beginner-friendly courses. Built for Ghana, the diaspora, and anyone worldwide — taught by AIGP-certified Patrik Barfi. Start free.')
@section('canonical_url', config('platform.url'))

@php
    $inst = config('platform.instructor');
    $priceMember = config('platform.prices.pro');
    $pricePro = config('platform.prices.elite');
    $faqs = \App\Http\Controllers\PageController::faqs();
    $testimonials = config('platform.testimonials', []);
    $startUrl = $freeCourse
        ? route('courses.show', $freeCourse)
        : (auth()->check() ? route('courses.index') : route('register'));
@endphp

@push('structured_data')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@graph": [
        {
            "@type": "Organization",
            "@id": "{{ config('platform.url') }}/#organization",
            "name": "{{ config('platform.parent_brand') }}",
            "url": "{{ config('platform.url') }}",
            "logo": "{{ asset('assets/logos/patrick_logo.png') }}",
            "description": @json(config('platform.entity_sentence')),
            "email": @json(config('platform.contact.email')),
            "founder": { "@id": "{{ config('platform.url') }}/#patrik-barfi" },
            "sameAs": [@json(config('platform.parent_url')), @json($inst['youtube'])]
        },
        {
            "@type": "Person",
            "@id": "{{ config('platform.url') }}/#patrik-barfi",
            "name": @json($inst['name']),
            "jobTitle": @json($inst['role']),
            "description": @json($inst['short_bio']),
            "url": "{{ route('about') }}",
            "sameAs": [@json($inst['youtube'])],
            "worksFor": { "@id": "{{ config('platform.url') }}/#organization" }
        },
        {
            "@type": "WebSite",
            "name": "{{ config('platform.name') }}",
            "url": "{{ config('platform.url') }}",
            "description": @json(config('platform.seo.default_description')),
            "publisher": { "@id": "{{ config('platform.url') }}/#organization" }
        },
        {
            "@type": "FAQPage",
            "mainEntity": [
                @foreach(array_slice($faqs, 0, 6) as $i => $faq)
                {
                    "@type": "Question",
                    "name": @json($faq['q']),
                    "acceptedAnswer": { "@type": "Answer", "text": @json($faq['a']) }
                }@if(!$loop->last),@endif
                @endforeach
            ]
        }
    ]
}
</script>
@endpush

@section('content')
{{-- ============================== HERO ============================== --}}
<section class="ai-hero">
    <div class="container ai-hero-content">
        <div class="row align-items-center g-5">
            <div class="col-lg-7">
                <div class="ai-badge"><i class="fas fa-bolt"></i> Make money with AI — no experience needed</div>
                <h1>Use AI to Earn More —<br>Wherever You Are.</h1>
                <p>
                    Practical, beginner-friendly AI courses that help you earn more, work faster, and build
                    modern skills. Built for Ghana and the diaspora — and open to anyone, anywhere.
                </p>
                <div class="d-flex flex-wrap align-items-center gap-3 mt-4">
                    <a href="{{ $startUrl }}" class="ai-btn ai-btn-primary btn-lg">
                        <i class="fas fa-play"></i> Start the Free AI Course
                    </a>
                    <a href="{{ route('membership.index') }}" class="text-decoration-none" style="color: rgba(255,255,255,0.85); font-weight: 600;">
                        See membership plans <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <p class="small mt-3 mb-0" style="color: rgba(255,255,255,0.7);">
                    <i class="fas fa-user-check me-1"></i> Taught by {{ $inst['name'] }} · AIGP-certified AI engineer &amp; instructor
                </p>
            </div>
            <div class="col-lg-5 d-none d-lg-block">
                <div class="ai-feature-grid">
                    <div class="ai-feature-item"><i class="fas fa-sack-dollar"></i><h6 class="text-white fw-bold mb-1">Earn-focused</h6><p class="mb-0 small" style="color: rgba(255,255,255,0.6);">Skills you can get paid for</p></div>
                    <div class="ai-feature-item"><i class="fas fa-seedling"></i><h6 class="text-white fw-bold mb-1">Beginner-friendly</h6><p class="mb-0 small" style="color: rgba(255,255,255,0.6);">Zero coding to start</p></div>
                    <div class="ai-feature-item"><i class="fas fa-brain"></i><h6 class="text-white fw-bold mb-1">AI Tutor</h6><p class="mb-0 small" style="color: rgba(255,255,255,0.6);">Ask questions on every lesson</p></div>
                    <div class="ai-feature-item"><i class="fas fa-globe-africa"></i><h6 class="text-white fw-bold mb-1">For everyone</h6><p class="mb-0 small" style="color: rgba(255,255,255,0.6);">Ghana, diaspora &amp; worldwide</p></div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===================== ENTITY SENTENCE (AEO) ===================== --}}
<section style="background: var(--ai-primary); color: #fff;">
    <div class="container py-3">
        <p class="mb-0 text-center fw-semibold" style="font-size: 1.05rem;">
            {{ config('platform.entity_sentence') }}
        </p>
    </div>
</section>

{{-- ========================= WHO IT'S FOR ========================= --}}
<section class="ai-section">
    <div class="container">
        <h2 class="ai-section-title">Who this is for</h2>
        <p class="ai-section-subtitle">If you want AI to actually make or save you money, you're in the right place.</p>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="ai-card p-4 h-100">
                    <i class="fas fa-briefcase fa-lg mb-2" style="color: var(--ai-primary);"></i>
                    <h5 class="fw-bold">Freelancers &amp; side-hustlers</h5>
                    <p class="text-muted mb-0 small">Offer AI-powered services — content, admin, design, support — and charge for faster, better work.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="ai-card p-4 h-100">
                    <i class="fas fa-user-tie fa-lg mb-2" style="color: var(--ai-primary);"></i>
                    <h5 class="fw-bold">Professionals &amp; job-seekers</h5>
                    <p class="text-muted mb-0 small">Stand out at work and on applications with real, demonstrable AI skills that save hours every week.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="ai-card p-4 h-100">
                    <i class="fas fa-store fa-lg mb-2" style="color: var(--ai-primary);"></i>
                    <h5 class="fw-bold">Small business owners</h5>
                    <p class="text-muted mb-0 small">Automate the repetitive parts of your business so you can serve more customers without more hours.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ====================== FEATURED COURSES ======================= --}}
<section class="ai-section" style="background: #fff; border-top: 1px solid var(--ai-border); border-bottom: 1px solid var(--ai-border);">
    <div class="container">
        <h2 class="ai-section-title">Courses</h2>
        <p class="ai-section-subtitle">Start free, then go deeper. Self-paced lessons you can take on any device.</p>
        @if($courses->count() > 0)
            <div class="row g-4">
                @foreach($courses as $course)
                    <div class="col-lg-4 col-md-6">
                        <div class="ai-card h-100">
                            <div class="ai-card-image">
                                @if($course->image)
                                    <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->name }}">
                                @else
                                    <i class="fas fa-robot text-white" style="font-size: 3rem; opacity: 0.8;"></i>
                                @endif
                            </div>
                            <div class="ai-card-body">
                                <div class="d-flex align-items-center flex-wrap gap-2 mb-2">
                                    <span class="ai-level-badge ai-level-{{ $course->level }}">{{ $course->level }}</span>
                                    @if($course->isFreePlan())
                                        <span class="badge bg-success">Free</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $course->tierLabel() }}</span>
                                    @endif
                                    <span class="text-muted small"><i class="fas fa-book-open"></i> {{ $course->lessons_count }} lessons</span>
                                </div>
                                <h5 class="fw-bold mb-2">{{ $course->name }}</h5>
                                <p class="text-muted small flex-grow-1">{{ Str::limit($course->description, 100) }}</p>
                                <p class="small fw-semibold mb-2">
                                    @if($course->isFreePlan())
                                        <span class="text-success">Free to enroll</span>
                                    @elseif($course->requiredPlan() === 'pro')
                                        Included with AI Member · ${{ $priceMember }}/mo
                                    @else
                                        Included with AI Pro · ${{ $pricePro }}/mo
                                    @endif
                                </p>
                                <a href="{{ route('courses.show', $course) }}" class="ai-btn ai-btn-primary w-100 justify-content-center mt-1">View course</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-muted text-center py-5">Courses coming soon.</p>
        @endif
    </div>
</section>

{{-- ==================== WHAT YOU'LL BE ABLE TO DO ================= --}}
<section class="ai-section">
    <div class="container">
        <h2 class="ai-section-title">What you'll be able to do</h2>
        <p class="ai-section-subtitle">Real outcomes, not just theory.</p>
        <div class="row g-3">
            @foreach([
                'Write, edit and research in minutes with AI — and charge for it',
                'Build simple automations that handle repetitive work for you',
                'Create content, images and marketing without a big team',
                'Use AI safely and responsibly (data, accuracy, governance)',
                'Turn AI skills into a service, a job edge, or a business',
                'Get unstuck fast with an AI tutor on every lesson',
            ] as $outcome)
                <div class="col-md-6">
                    <div class="d-flex align-items-start gap-3 p-3 ai-card">
                        <i class="fas fa-circle-check mt-1" style="color: var(--ai-primary);"></i>
                        <span>{{ $outcome }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ======================= LEAD MAGNET BAND ===================== --}}
<section class="ai-section">
    <div class="container">
        <div class="ai-card p-4 p-lg-5" style="background: var(--ai-gradient); color:#fff;">
            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <div class="ai-badge mb-2" style="background: rgba(255,255,255,0.15); color:#fff;"><i class="fas fa-gift"></i> Free download</div>
                    <h2 class="fw-bold mb-2" style="color:#fff;">{{ config('platform.lead_magnet.title') }}</h2>
                    <p class="mb-0" style="color: rgba(255,255,255,0.9); max-width: 60ch;">{{ config('platform.lead_magnet.subtitle') }} Get the top AI skills, a prompt framework, and a 7-day plan.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="{{ route('lead.show') }}" class="ai-btn" style="background:#fff;color:var(--ai-primary);font-weight:700;"><i class="fas fa-download"></i> Get the free kit</a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ======================= INSTRUCTOR BLOCK ====================== --}}
<section class="ai-section" style="background: #fff; border-top: 1px solid var(--ai-border);">
    <div class="container">
        @include('partials.instructor')
        <div class="text-center mt-3">
            <a href="{{ route('about') }}" class="text-decoration-none fw-semibold" style="color: var(--ai-primary);">
                More about Patrik &amp; Patrik Solutions <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
</section>

{{-- ======================= TESTIMONIALS (only if real ones exist) === --}}
@if(count($testimonials) > 0)
<section class="ai-section">
    <div class="container">
        <h2 class="ai-section-title">What learners say</h2>
        <div class="row g-4">
            @foreach($testimonials as $t)
                <div class="col-md-4">
                    <div class="ai-card p-4 h-100">
                        <i class="fas fa-quote-left mb-2" style="color: var(--ai-primary);"></i>
                        <p class="mb-3">{{ $t['quote'] }}</p>
                        <p class="mb-0 fw-bold">{{ $t['name'] }}</p>
                        @if(!empty($t['detail']))<p class="small text-muted mb-0">{{ $t['detail'] }}</p>@endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- =========================== FAQ TEASER ======================== --}}
<section class="ai-section" style="background: #fff; border-top: 1px solid var(--ai-border);">
    <div class="container">
        <h2 class="ai-section-title">Frequently asked questions</h2>
        <div class="row justify-content-center">
            <div class="col-lg-9">
                @foreach(array_slice($faqs, 0, 4) as $faq)
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

{{-- =========================== FINAL CTA ========================= --}}
<section class="ai-hero" style="padding: 4rem 0;">
    <div class="container ai-hero-content text-center">
        <h2 class="fw-bold mb-3" style="font-size: 2rem;">Start making money with AI today</h2>
        <p class="mx-auto mb-4" style="max-width: 540px;">Create a free account and begin the AI Fundamentals course — no card required.</p>
        <a href="{{ $startUrl }}" class="ai-btn ai-btn-primary btn-lg"><i class="fas fa-play"></i> Start the Free AI Course</a>
    </div>
</section>
@endsection
