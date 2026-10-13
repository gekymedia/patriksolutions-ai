@extends('layouts.platform')
@section('title', 'Free Download: ' . config('platform.lead_magnet.title'))
@section('meta_description', 'Get The AI Income Starter Kit free — a practical guide to using AI to earn more, with the top skills, a prompt framework, a 7-day plan, and free tools. No experience needed.')
@section('canonical_url', route('lead.show'))

@section('content')
<section class="ai-section" style="padding-top: 3rem;">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6">
                <div class="ai-badge mb-3"><i class="fas fa-gift"></i> Free download</div>
                <h1 class="fw-bold mb-3">{{ config('platform.lead_magnet.title') }}</h1>
                <p class="lead text-muted">{{ config('platform.lead_magnet.subtitle') }}</p>
                <ul class="list-unstyled mt-4">
                    @foreach([
                        'The 5 highest-value AI skills to start earning with',
                        'The R-T-C-F-T prompt framework that gets great results',
                        'A simple 7-day action plan to land your first client',
                        'The free tools to use — no coding, no big budget',
                    ] as $point)
                        <li class="d-flex align-items-start gap-3 mb-2">
                            <i class="fas fa-circle-check mt-1" style="color: var(--ai-primary);"></i>
                            <span>{{ $point }}</span>
                        </li>
                    @endforeach
                </ul>
                <p class="small text-muted"><i class="fas fa-lock me-1"></i> We respect your privacy. Unsubscribe anytime. See our <a href="{{ route('privacy') }}">Privacy Policy</a>.</p>
            </div>
            <div class="col-lg-6">
                <div class="ai-card p-4 p-lg-5">
                    <h2 class="h5 fw-bold mb-3">Get instant access</h2>
                    <form method="POST" action="{{ route('lead.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="ai-form-label">First name</label>
                            <input id="name" type="text" name="name" class="ai-form-control" value="{{ old('name') }}" required autocomplete="given-name">
                            @error('name')<div class="ai-form-error">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-4">
                            <label for="email" class="ai-form-label">Email address</label>
                            <input id="email" type="email" name="email" class="ai-form-control" value="{{ old('email') }}" required autocomplete="email">
                            @error('email')<div class="ai-form-error">{{ $message }}</div>@enderror
                        </div>
                        <button type="submit" class="ai-btn ai-btn-primary w-100 justify-content-center">
                            <i class="fas fa-download"></i> Send me the free kit
                        </button>
                    </form>
                    <p class="small text-muted text-center mt-3 mb-0">You'll get the PDF on the next page, instantly.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
