@extends('layouts.platform')
@section('title', $course->name)

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
                <h1 class="fw-bold mt-2">{{ $course->name }}</h1>
                <p class="text-muted">{{ $course->description }}</p>
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
                            @if(auth()->user()->hasCourseAccess())
                                <form action="{{ route('courses.enroll', $course) }}" method="POST">@csrf
                                    <button type="submit" class="ai-btn ai-btn-primary w-100 justify-content-center">Enroll Now</button>
                                </form>
                            @else
                                <a href="{{ route('membership.index') }}" class="ai-btn ai-btn-primary w-100 justify-content-center">
                                    <i class="fas fa-crown"></i> Become a Member to Enroll
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login', ['redirect' => route('courses.show', $course)]) }}" class="ai-btn ai-btn-primary w-100 justify-content-center">Login to Enroll</a>
                            <a href="{{ route('register', ['redirect' => route('membership.index')]) }}" class="ai-btn ai-btn-dark w-100 justify-content-center mt-2">Sign Up &amp; Join</a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
<section class="ai-section">
    <div class="container">
        <h2 class="h5 fw-bold mb-3">Curriculum</h2>
        <div class="ai-card">
            @foreach($course->lessons as $i => $lesson)
                <div class="d-flex align-items-center p-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                    <span class="text-muted me-3">{{ $i + 1 }}</span>
                    <div class="flex-grow-1">
                        <div class="fw-semibold">{{ $lesson->title }}</div>
                        <div class="small text-muted">{{ Str::limit($lesson->description, 80) }}</div>
                    </div>
                    @if(in_array($lesson->id, $completedLessonIds))
                        <span class="badge bg-success">Done</span>
                    @elseif($isEnrolled)
                        <a href="{{ route('lessons.show', [$course, $lesson]) }}" class="ai-btn ai-btn-dark" style="padding: 0.375rem 0.875rem; font-size: 0.8125rem;">Start</a>
                    @else
                        <i class="fas fa-lock text-muted"></i>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
