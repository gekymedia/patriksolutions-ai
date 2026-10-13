@extends('layouts.platform')
@section('title', 'Contact Patrik Solutions AI')
@section('meta_description', 'Get in touch with Patrik Solutions AI by email or WhatsApp — questions about courses, membership, billing, or anything else. We reply as soon as we can.')
@section('canonical_url', route('contact'))

@php
    $wa = config('platform.contact.whatsapp');
    $waLabel = config('platform.contact.whatsapp_label') ?: $wa;
    $contactEmail = config('platform.contact.email');
@endphp

@section('content')
<section class="ai-section" style="padding-top: 3rem;">
    <div class="container">
        <div class="ai-badge mb-3"><i class="fas fa-envelope"></i> Contact</div>
        <h1 class="ai-section-title text-start">Get in touch</h1>
        <p class="text-muted" style="max-width: 60ch;">
            Questions about courses, membership, billing, or partnerships? We'd love to hear from you and
            usually reply within one to two business days.
        </p>

        <div class="row g-4 mt-2">
            <div class="col-md-6 col-lg-4">
                <div class="ai-card p-4 h-100 text-center">
                    <i class="fas fa-envelope fa-2x mb-3" style="color: var(--ai-primary);"></i>
                    <h2 class="h6 fw-bold">Email</h2>
                    <p class="small text-muted mb-3">Best for detailed questions and billing.</p>
                    <a href="mailto:{{ $contactEmail }}" class="ai-btn ai-btn-primary w-100 justify-content-center">{{ $contactEmail }}</a>
                </div>
            </div>
            @if($wa)
            <div class="col-md-6 col-lg-4">
                <div class="ai-card p-4 h-100 text-center">
                    <i class="fab fa-whatsapp fa-2x mb-3" style="color: #25D366;"></i>
                    <h2 class="h6 fw-bold">WhatsApp</h2>
                    <p class="small text-muted mb-3">Quick questions and support.</p>
                    <a href="https://wa.me/{{ $wa }}" rel="noopener" target="_blank" class="ai-btn ai-btn-dark w-100 justify-content-center">{{ $waLabel }}</a>
                </div>
            </div>
            @endif
            <div class="col-md-6 col-lg-4">
                <div class="ai-card p-4 h-100 text-center">
                    <i class="fab fa-youtube fa-2x mb-3" style="color: #FF0000;"></i>
                    <h2 class="h6 fw-bold">YouTube</h2>
                    <p class="small text-muted mb-3">Free AI &amp; money lessons every week.</p>
                    <a href="{{ config('platform.instructor.youtube') }}" rel="noopener" target="_blank" class="ai-btn ai-btn-dark w-100 justify-content-center">Visit channel</a>
                </div>
            </div>
        </div>

        <div class="ai-card p-4 mt-4">
            <p class="small text-muted mb-0">
                <i class="fas fa-circle-question me-2" style="color: var(--ai-primary);"></i>
                Looking for a quick answer? Many common questions about pricing, access, and refunds are covered on our
                <a href="{{ route('faq') }}">FAQ page</a>.
            </p>
        </div>
    </div>
</section>
@endsection
