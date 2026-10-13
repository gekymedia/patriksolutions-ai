@extends('layouts.platform')
@section('title', 'AI Courses — Make Money With AI | ' . config('platform.name'))
@section('meta_description', 'Practical, beginner-friendly AI courses: AI Fundamentals (free), AI for Business & Productivity, and Advanced AI Strategies. Learn to earn more with AI — start free.')
@section('canonical_url', route('courses.index'))

@section('content')
<section class="ai-section" style="padding-top: 3rem;">
    <div class="container">
        <h1 class="ai-section-title">All Courses</h1>
        <p class="ai-section-subtitle">Practical, hands-on AI training. Start free, then go deeper.</p>
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
                        @php $accessible = in_array($course->id, $accessibleIds); @endphp
                        <div class="ai-card-body">
                            <span class="ai-level-badge ai-level-{{ $course->level }}">{{ $course->level }}</span>
                            @unless($course->isFreePlan())
                                <span class="badge {{ $accessible ? 'bg-success' : 'bg-secondary' }} ms-1">@unless($accessible)<i class="fas fa-lock"></i> @endunless{{ $course->tierLabel() }}</span>
                            @else
                                <span class="badge bg-success ms-1">Free</span>
                            @endunless
                            <span class="text-muted small ms-2"><i class="fas fa-book-open"></i> {{ $course->lessons_count }} lessons</span>
                            <h5 class="fw-bold my-2">{{ $course->name }}</h5>
                            <p class="text-muted small flex-grow-1">{{ Str::limit($course->description, 120) }}</p>
                            <p class="small fw-semibold mb-2">
                                @if($course->isFreePlan())
                                    <span class="text-success">Free to enroll</span>
                                @elseif($course->requiredPlan() === 'pro')
                                    Included with AI Member · ${{ config('platform.prices.pro') }}/mo
                                @else
                                    Included with AI Pro · ${{ config('platform.prices.elite') }}/mo
                                @endif
                            </p>
                            <a href="{{ route('courses.show', $course) }}" class="ai-btn {{ $accessible || in_array($course->id, $enrolledIds) ? 'ai-btn-primary' : 'ai-btn-dark' }} w-100 justify-content-center">
                                @if(in_array($course->id, $enrolledIds))
                                    Continue
                                @elseif($accessible)
                                    View &amp; Enroll
                                @else
                                    <i class="fas fa-lock"></i> View course
                                @endif
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
