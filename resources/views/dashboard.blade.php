@extends('layouts.platform')
@section('title', 'My Learning')

@section('content')
<section class="ai-section" style="padding-top: 3rem;">
    <div class="container">
        <h1 class="ai-section-title">My Learning</h1>
        @if($courses->count() > 0)
            <div class="row g-4">
                @foreach($courses as $course)
                    <div class="col-lg-6">
                        <div class="ai-card p-4">
                            <h5 class="fw-bold">{{ $course->name }}</h5>
                            <p class="small text-muted">{{ $course->completed_lessons }} / {{ $course->lessons_count }} lessons</p>
                            <div class="ai-progress-bar mb-3"><div class="ai-progress-fill" style="width: {{ $course->progress_percent }}%"></div></div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('courses.show', $course) }}" class="ai-btn ai-btn-dark flex-grow-1 justify-content-center">View</a>
                                @if($course->progress_percent < 100)
                                    @php $next = $course->lessons()->orderBy('sort_order')->get()->first(fn($l) => !$l->isCompletedBy(auth()->id())); @endphp
                                    @if($next)
                                        <a href="{{ route('lessons.show', [$course, $next]) }}" class="ai-btn ai-btn-primary"><i class="fas fa-play"></i></a>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <p class="text-muted mb-3">No enrolled courses yet.</p>
                <a href="{{ route('courses.index') }}" class="ai-btn ai-btn-primary">Browse Courses</a>
            </div>
        @endif
    </div>
</section>
@endsection
