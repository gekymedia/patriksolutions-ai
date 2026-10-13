@extends('layouts.platform')
@section('title', 'About Patrik Solutions AI & Patrik Barfi')
@section('meta_description', 'Patrik Solutions AI helps people in Ghana, the diaspora, and worldwide use AI to earn more and build modern skills — led by AIGP-certified AI engineer Patrik Barfi.')
@section('canonical_url', route('about'))

@push('structured_data')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "AboutPage",
    "name": "About Patrik Solutions AI",
    "url": "{{ route('about') }}",
    "mainEntity": {
        "@type": "Person",
        "@id": "{{ config('platform.url') }}/#patrik-barfi",
        "name": @json(config('platform.instructor.name')),
        "jobTitle": @json(config('platform.instructor.role')),
        "description": @json(config('platform.instructor.short_bio')),
        "worksFor": {
            "@type": "Organization",
            "name": "{{ config('platform.parent_brand') }}",
            "url": "{{ config('platform.url') }}"
        },
        "sameAs": [@json(config('platform.instructor.youtube'))]
    }
}
</script>
@endpush

@section('content')
<section class="ai-section" style="padding-top: 3rem;">
    <div class="container">
        <div class="ai-badge mb-3"><i class="fas fa-circle-info"></i> About</div>
        <h1 class="ai-section-title text-start">Learn AI to earn more — wherever you are</h1>
        <p class="lead text-muted" style="max-width: 70ch;">{{ config('platform.entity_sentence') }}</p>

        <div class="row g-4 mt-2">
            <div class="col-lg-7">
                <h2 class="h4 fw-bold">Why Patrik Solutions AI exists</h2>
                <p class="text-muted">
                    AI is changing how people work and earn — but most training is either too technical, too
                    theoretical, or priced for big companies. Patrik Solutions AI was built to fix that: clear,
                    practical, beginner-friendly courses that focus on one thing — helping you use AI to earn more,
                    work faster, and build skills that pay off in the real world.
                </p>
                <p class="text-muted">
                    We're proudly rooted in Ghana and built with the diaspora in mind, and the lessons work for
                    anyone, anywhere. Whether you want to start an AI side-hustle, stand out at work, or automate
                    your small business, you'll find a straightforward path here.
                </p>

                <h2 class="h4 fw-bold mt-4">What makes it different</h2>
                <ul class="text-muted">
                    <li><strong>Earn-focused:</strong> every course ties back to making or saving money with AI.</li>
                    <li><strong>No jargon:</strong> plain-English lessons; coding is optional and clearly marked.</li>
                    <li><strong>Responsible AI:</strong> taught by an AIGP-certified instructor, so you learn to use AI safely and ethically.</li>
                    <li><strong>Support built in:</strong> an AI tutor on every lesson, plus live Q&amp;As and coaching on paid plans.</li>
                </ul>
            </div>
            <div class="col-lg-5">
                <div class="ai-card p-4">
                    <h3 class="h6 fw-bold mb-3">Who we serve</h3>
                    <p class="small text-muted mb-3"><i class="fas fa-globe-africa me-2" style="color: var(--ai-primary);"></i> People in Ghana and across the African diaspora (USA, UK, Canada, Europe) — and learners worldwide.</p>
                    <p class="small text-muted mb-3"><i class="fas fa-briefcase me-2" style="color: var(--ai-primary);"></i> Freelancers, professionals, job-seekers, and small business owners.</p>
                    <p class="small text-muted mb-0"><i class="fas fa-seedling me-2" style="color: var(--ai-primary);"></i> Complete beginners — no coding or prior AI experience required.</p>
                </div>
            </div>
        </div>

        <div class="mt-5">
            @include('partials.instructor')
        </div>

        <div class="text-center mt-5">
            <a href="{{ auth()->check() ? route('courses.index') : route('register') }}" class="ai-btn ai-btn-primary btn-lg"><i class="fas fa-play"></i> Start the Free AI Course</a>
        </div>
    </div>
</section>
@endsection
