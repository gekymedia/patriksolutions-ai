@extends('layouts.platform')
@section('title', 'Your free kit is ready')
@section('meta_robots', 'noindex, nofollow')
@section('canonical_url', route('lead.thanks'))

@php $pdf = asset(config('platform.lead_magnet.file')); @endphp

@push('scripts')
{{-- Auto-start the download (same-origin) without leaving the page; button is the backup. --}}
<script>
window.addEventListener('load', function () {
    setTimeout(function () {
        var a = document.createElement('a');
        a.href = @json($pdf);
        a.setAttribute('download', '');
        document.body.appendChild(a);
        a.click();
        a.remove();
    }, 800);
});
</script>
@endpush

@section('content')
<section class="ai-section" style="padding-top: 3rem;">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-7">
                <i class="fas fa-circle-check mb-3" style="color: #22c55e; font-size: 3rem;"></i>
                <h1 class="fw-bold mb-2">You're in{{ session('lead_name') ? ', ' . session('lead_name') : '' }}! 🎉</h1>
                <p class="text-muted mb-4">Your copy of <strong>{{ config('platform.lead_magnet.title') }}</strong> is downloading now. If it doesn't start, tap the button below.</p>

                <a href="{{ $pdf }}" class="ai-btn ai-btn-primary btn-lg" download>
                    <i class="fas fa-download"></i> Download the AI Income Starter Kit
                </a>

                <div class="ai-card p-4 p-lg-5 mt-5 text-start">
                    <h2 class="h5 fw-bold mb-2">Your next step</h2>
                    <p class="text-muted mb-3">The kit is the map. The free <strong>AI Fundamentals</strong> course is the guided walk-through — from zero to confidently using AI, with an instructor and an AI tutor.</p>
                    <a href="{{ auth()->check() ? route('courses.index') : route('register') }}" class="ai-btn ai-btn-dark">
                        <i class="fas fa-play"></i> Start the Free AI Course
                    </a>
                </div>

                <p class="small text-muted mt-4">
                    Want to go deeper? Browse the <a href="{{ route('guides.index') }}">free guides</a> or
                    <a href="{{ route('membership.index') }}">membership plans</a>.
                </p>
            </div>
        </div>
    </div>
</section>
@endsection
