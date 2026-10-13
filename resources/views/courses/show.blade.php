@extends('layouts.platform')
@section('title', $course->name . ' — ' . config('platform.name'))
@section('meta_description', Str::limit(strip_tags($course->description), 160))
@section('og_type', 'article')
@section('canonical_url', route('courses.show', $course))

@php
    $coursePrice = $course->isFreePlan() ? 0 : ($course->requiredPlan() === 'pro' ? config('platform.prices.pro') : config('platform.prices.elite'));
@endphp
@push('structured_data')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Course",
    "name": @json($course->name),
    "description": @json(strip_tags($course->description)),
    "url": @json(route('courses.show', $course)),
    "provider": {
        "@type": "Organization",
        "name": "{{ config('platform.parent_brand') }}",
        "url": "{{ config('platform.url') }}"
    },
    "instructor": {
        "@type": "Person",
        "name": @json(config('platform.instructor.name')),
        "jobTitle": @json(config('platform.instructor.role'))
    },
    "educationalLevel": @json(ucfirst($course->level)),
    "offers": {
        "@type": "Offer",
        "category": @json($course->tierLabel()),
        "price": "{{ $coursePrice }}",
        "priceCurrency": "USD",
        "availability": "https://schema.org/InStock",
        "url": @json($course->isFreePlan() ? route('courses.show', $course) : route('membership.index'))
    },
    "hasCourseInstance": {
        "@type": "CourseInstance",
        "courseMode": "online",
        "courseWorkload": "PT{{ $course->lessons->count() }}H"
    }
}
</script>
@endpush

@section('content')
<section class="ai-section" style="padding-top: 2rem; background: #fff; border-bottom: 1px solid var(--ai-border);">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('courses.index') }}">Courses</a></li>
                <li class="breadcrumb-item active">{{ $course->name }}</li>
            </ol>
        </nav>
        <div class="row g-4">
            <div class="col-lg-8">
                <span class="ai-level-badge ai-level-{{ $course->level }}">{{ $course->level }}</span>
                @unless($course->isFreePlan())
                    <span class="badge {{ $canAccess ? 'bg-success' : 'bg-secondary' }} ms-1">@unless($canAccess)<i class="fas fa-lock"></i> @endunless{{ $course->tierLabel() }}</span>
                @else
                    <span class="badge bg-success ms-1">Free</span>
                @endunless
                <h1 class="fw-bold mt-2">{{ $course->name }}</h1>
                <p class="text-muted">{{ $course->description }}</p>
                <div class="d-flex flex-wrap gap-3 small text-muted mb-1">
                    <span><i class="fas fa-signal me-1" style="color: var(--ai-primary);"></i> {{ ucfirst($course->level) }}</span>
                    <span><i class="fas fa-book-open me-1" style="color: var(--ai-primary);"></i> {{ $course->lessons->count() }} lessons</span>
                    <span><i class="fas fa-infinity me-1" style="color: var(--ai-primary);"></i> Self-paced</span>
                    <span>
                        <i class="fas fa-tag me-1" style="color: var(--ai-primary);"></i>
                        @if($course->isFreePlan())
                            Free to enroll
                        @elseif($course->requiredPlan() === 'pro')
                            Included with AI Member (${{ config('platform.prices.pro') }}/mo)
                        @else
                            Included with AI Pro (${{ config('platform.prices.elite') }}/mo)
                        @endif
                    </span>
                </div>
                @if($isEnrolled)
                    <div class="mt-3">
                        <div class="d-flex justify-content-between small mb-1"><span>Progress</span><span>{{ $progressPercent }}%</span></div>
                        <div class="ai-progress-bar"><div class="ai-progress-fill" style="width: {{ $progressPercent }}%"></div></div>
                    </div>
                @endif
            </div>
            <div class="col-lg-4">
                <div class="ai-card p-4">
                    @if($isEnrolled)
                        @php $next = $course->lessons->first(fn($l) => !in_array($l->id, $completedLessonIds)); @endphp
                        @if($next)
                            <a href="{{ route('lessons.show', [$course, $next]) }}" class="ai-btn ai-btn-primary w-100 justify-content-center mb-2"><i class="fas fa-play"></i> Continue</a>
                        @else
                            <p class="text-center fw-bold text-success"><i class="fas fa-trophy"></i> Completed!</p>
                        @endif
                    @else
                        @auth
                            @if($canAccess)
                                <form action="{{ route('courses.enroll', $course) }}" method="POST">@csrf
                                    <button type="submit" class="ai-btn ai-btn-primary w-100 justify-content-center">Enroll Now</button>
                                </form>
                                @unless($course->isFreePlan())
                                    <p class="small text-muted text-center mt-2 mb-0"><i class="fas fa-check-circle text-success"></i> Included in your {{ $course->tierLabel() }} plan.</p>
                                @endunless
                            @else
                                <p class="small text-center mb-2"><i class="fas fa-lock"></i> Requires <strong>{{ $course->tierLabel() }}</strong></p>
                                <a href="{{ route('membership.index') }}" class="ai-btn ai-btn-primary w-100 justify-content-center">
                                    <i class="fas fa-crown"></i> {{ $course->requiredPlan() === 'elite' ? 'Upgrade to AI Pro' : 'Upgrade to AI Member' }}
                                </a>
                                <p class="small text-muted text-center mt-2 mb-0">{{ $upgradeMessage }}</p>
                            @endif
                        @else
                            @if($course->isFreePlan())
                                <a href="{{ route('register', ['redirect' => route('courses.show', $course)]) }}" class="ai-btn ai-btn-primary w-100 justify-content-center"><i class="fas fa-user-plus"></i> Sign up free &amp; enroll</a>
                                <p class="small text-muted text-center mt-2 mb-0">Free course — no card required.</p>
                            @else
                                <a href="{{ route('register', ['redirect' => route('membership.index', ['plan' => $course->requiredPlan()])]) }}" class="ai-btn ai-btn-primary w-100 justify-content-center"><i class="fas fa-crown"></i> {{ $course->requiredPlan() === 'elite' ? 'Get AI Pro — $' . config('platform.prices.elite') . '/mo' : 'Get AI Member — $' . config('platform.prices.pro') . '/mo' }}</a>
                                <p class="small text-muted text-center mt-2 mb-0">{{ $upgradeMessage }}</p>
                            @endif
                            <a href="{{ route('login', ['redirect' => route('courses.show', $course)]) }}" class="ai-btn ai-btn-dark w-100 justify-content-center mt-2">Log in</a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@php $outcomes = config('platform.course_outcomes.' . $course->slug, []); @endphp
@if(!empty($outcomes))
<section class="ai-section" style="padding-bottom: 0;">
    <div class="container">
        <h2 class="h5 fw-bold mb-3">What you'll be able to do</h2>
        <div class="row g-3">
            @foreach($outcomes as $outcome)
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
@endif
<section class="ai-section">
    <div class="container">
        <h2 class="h5 fw-bold mb-3">Curriculum</h2>
        <div class="ai-card">
            @foreach($course->lessons as $i => $lesson)
                @php $lessonOpen = $isEnrolled || $canAccess || $lesson->is_preview; @endphp
                <div class="d-flex align-items-center p-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                    <span class="text-muted me-3">{{ $i + 1 }}</span>
                    <div class="flex-grow-1">
                        <div class="fw-semibold">
                            {{ $lesson->title }}
                            @if($lesson->is_preview && !$canAccess)<span class="badge bg-info text-dark ms-1">Free preview</span>@endif
                        </div>
                        <div class="small text-muted">{{ Str::limit($lesson->description, 80) }}</div>
                    </div>
                    @if(in_array($lesson->id, $completedLessonIds))
                        <span class="badge bg-success">Done</span>
                    @elseif($lessonOpen)
                        <a href="{{ route('lessons.show', [$course, $lesson]) }}" class="ai-btn ai-btn-dark" style="padding: 0.375rem 0.875rem; font-size: 0.8125rem;">{{ ($lesson->is_preview && !$canAccess) ? 'Preview' : 'Start' }}</a>
                    @else
                        <i class="fas fa-lock text-muted"></i>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
