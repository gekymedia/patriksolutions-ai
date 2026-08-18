@extends('layouts.platform')
@section('title', config('platform.name') . ' — Learn AI Skills')

@section('content')
<section class="ai-hero">
    <div class="container ai-hero-content">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <div class="ai-badge"><i class="fas fa-robot"></i> ai.patriksolutions.com</div>
                <h1>Master AI with Expert-Led Courses</h1>
                <p>{{ config('platform.tagline') }}. Learn practical AI skills with hands-on lessons and your personal AI tutor on every lesson.</p>
                <div class="d-flex flex-wrap gap-3 mt-4">
                    <a href="{{ route('courses.index') }}" class="ai-btn ai-btn-primary"><i class="fas fa-play"></i> Browse Courses</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="ai-btn ai-btn-outline"><i class="fas fa-chart-line"></i> My Learning</a>
                    @else
                        <a href="{{ route('register') }}" class="ai-btn ai-btn-outline"><i class="fas fa-user-plus"></i> Start Free</a>
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
@endsection
