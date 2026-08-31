@extends('layouts.platform')
@section('title', config('platform.name') . ' — Learn AI Skills')
@section('meta_description', 'Learn artificial intelligence, build wealth, and shape the future. Expert-led AI courses, AI tutor, video lessons, and progress tracking from Patrik Solutions.')
@section('canonical_url', config('platform.url'))

@push('structured_data')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@graph": [
        {
            "@type": "Organization",
            "name": "{{ config('platform.parent_brand') }}",
            "url": "{{ config('platform.url') }}",
            "logo": "{{ asset('assets/logos/patrick_logo.png') }}",
            "sameAs": [@json(config('platform.parent_url'))]
        },
        {
            "@type": "WebSite",
            "name": "{{ config('platform.name') }}",
            "url": "{{ config('platform.url') }}",
            "description": @json(config('platform.seo.default_description')),
            "publisher": {
                "@type": "Organization",
                "name": "{{ config('platform.parent_brand') }}"
            }
        }
    ]
}
</script>
@endpush

@section('content')
<section class="ai-hero">
    <div class="container ai-hero-content">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <div class="ai-badge"><i class="fas fa-robot"></i> ai.patriksolutions.com</div>
                <h1>
                    Learn Artificial Intelligence.<br>
                    Build Wealth.<br>
                    Shape the Future.
                </h1>
                <p>Master practical AI skills, accelerate your career, automate your business, and make smarter financial decisions with expert-led training from Patrik Solutions.</p>
                <div class="d-flex flex-wrap gap-3 mt-4">
                    <a href="{{ route('courses.index') }}" class="ai-btn ai-btn-primary"><i class="fas fa-play"></i> Browse Courses</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="ai-btn ai-btn-outline"><i class="fas fa-chart-line"></i> My Learning</a>
                    @else
                        <a href="{{ route('register') }}" class="ai-btn ai-btn-outline"><i class="fas fa-user-plus"></i> Create Account</a>
                        <a href="{{ route('membership.index') }}" class="ai-btn ai-btn-primary"><i class="fas fa-crown"></i> Become a Member</a>
                    @endauth
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-block">
                <div class="ai-feature-grid">
                    <div class="ai-feature-item"><i class="fas fa-brain"></i><h6 class="text-white fw-bold mb-1">AI Tutor</h6><p class="mb-0 small" style="color: rgba(255,255,255,0.6);">Ask questions anytime</p></div>
                    <div class="ai-feature-item"><i class="fas fa-video"></i><h6 class="text-white fw-bold mb-1">Video Lessons</h6><p class="mb-0 small" style="color: rgba(255,255,255,0.6);">Learn at your pace</p></div>
                    <div class="ai-feature-item"><i class="fas fa-certificate"></i><h6 class="text-white fw-bold mb-1">Progress Tracking</h6><p class="mb-0 small" style="color: rgba(255,255,255,0.6);">Track your journey</p></div>
                    <div class="ai-feature-item"><i class="fas fa-lock"></i><h6 class="text-white fw-bold mb-1">Focused Learning</h6><p class="mb-0 small" style="color: rgba(255,255,255,0.6);">AI materials only</p></div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="ai-section">
    <div class="container">
        <h2 class="ai-section-title">Featured Courses</h2>
        <p class="ai-section-subtitle">Enroll and start learning — your dedicated AI learning space.</p>
        @if($courses->count() > 0)
            <div class="row g-4">
                @foreach($courses as $course)
                    <div class="col-lg-4 col-md-6">
                        <div class="ai-card">
                            <div class="ai-card-image">
                                @if($course->image)
                                    <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->name }}">
                                @else
                                    <i class="fas fa-robot text-white" style="font-size: 3rem; opacity: 0.8;"></i>
                                @endif
                            </div>
                            <div class="ai-card-body">
                                <span class="ai-level-badge ai-level-{{ $course->level }} mb-2">{{ $course->level }}</span>
                                <h5 class="fw-bold mb-2">{{ $course->name }}</h5>
                                <p class="text-muted small flex-grow-1">{{ Str::limit($course->description, 100) }}</p>
                                <a href="{{ route('courses.show', $course) }}" class="ai-btn ai-btn-primary w-100 justify-content-center mt-2">View Course</a>
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

<section class="ai-hero" style="padding: 4rem 0;">
    <div class="container ai-hero-content text-center">
        <h2 class="fw-bold mb-3" style="font-size: 2rem;">Ready to start learning?</h2>
        <p class="mx-auto mb-4" style="max-width: 520px;">Become a member to unlock all AI courses, your personal AI tutor, and progress tracking.</p>
        <a href="{{ route('membership.index') }}" class="ai-btn ai-btn-primary btn-lg"><i class="fas fa-crown"></i> View Membership Plans</a>
    </div>
</section>
@endsection
