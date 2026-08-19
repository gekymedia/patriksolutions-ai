@extends('layouts.platform')
@section('title', 'AI Courses — ' . config('platform.name'))
@section('meta_description', 'Browse practical, hands-on AI training courses. Learn machine learning, automation, and real-world AI skills with expert-led lessons from Patrik Solutions.')

@section('content')
<section class="ai-section" style="padding-top: 3rem;">
    <div class="container">
        <h1 class="ai-section-title">All Courses</h1>
        <p class="ai-section-subtitle">Practical, hands-on AI training.</p>
        <div class="row g-4">
            @foreach($courses as $course)
                <div class="col-lg-4 col-md-6">
                    <div class="ai-card">
                        <div class="ai-card-image">
                            @if($course->image)
                                <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->name }}">
                            @else
                                <i class="fas fa-robot text-white" style="font-size: 3rem;"></i>
                            @endif
                        </div>
                        <div class="ai-card-body">
                            <span class="ai-level-badge ai-level-{{ $course->level }}">{{ $course->level }}</span>
                            <span class="text-muted small ms-2"><i class="fas fa-book-open"></i> {{ $course->lessons_count }} lessons</span>
                            <h5 class="fw-bold my-2">{{ $course->name }}</h5>
                            <p class="text-muted small flex-grow-1">{{ Str::limit($course->description, 120) }}</p>
                            <a href="{{ route('courses.show', $course) }}" class="ai-btn ai-btn-primary w-100 justify-content-center">
                                {{ in_array($course->id, $enrolledIds) ? 'Continue' : 'View & Enroll' }}
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
