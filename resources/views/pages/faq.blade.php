@extends('layouts.platform')
@section('title', 'FAQ — Making Money With AI, Courses & Membership')
@section('meta_description', 'Answers to common questions about Patrik Solutions AI: how to make money with AI, pricing, free options, the AI tutor, refunds, and payment methods for Ghana and worldwide.')
@section('canonical_url', route('faq'))

@push('structured_data')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "FAQPage",
    "mainEntity": [
        @foreach($faqs as $faq)
        {
            "@type": "Question",
            "name": @json($faq['q']),
            "acceptedAnswer": { "@type": "Answer", "text": @json($faq['a']) }
        }@if(!$loop->last),@endif
        @endforeach
    ]
}
</script>
@endpush

@section('content')
<section class="ai-section" style="padding-top: 3rem;">
    <div class="container">
        <div class="ai-badge mb-3"><i class="fas fa-circle-question"></i> FAQ</div>
        <h1 class="ai-section-title text-start">Frequently asked questions</h1>
        <p class="text-muted" style="max-width: 60ch;">
            Everything you need to know about learning with Patrik Solutions AI. Still stuck?
            <a href="{{ route('contact') }}">Contact us</a>.
        </p>

        <div class="row justify-content-center mt-2">
            <div class="col-lg-9">
                @foreach($faqs as $faq)
                    <div class="ai-card p-4 mb-3">
                        <h2 class="h5 fw-bold mb-2">{{ $faq['q'] }}</h2>
                        <p class="text-muted mb-0">{{ $faq['a'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="{{ auth()->check() ? route('courses.index') : route('register') }}" class="ai-btn ai-btn-primary btn-lg"><i class="fas fa-play"></i> Start the Free AI Course</a>
        </div>
    </div>
</section>
@endsection
