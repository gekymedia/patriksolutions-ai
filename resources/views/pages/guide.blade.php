@extends('layouts.platform')
@section('title', $guide['title'] . ' | ' . config('platform.name'))
@section('meta_description', $guide['description'])
@section('meta_keywords', $guide['keywords'] ?? '')
@section('og_type', 'article')
@section('canonical_url', route('guides.show', $slug))

@push('structured_data')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@graph": [
        {
            "@type": "Article",
            "headline": @json($guide['title']),
            "description": @json($guide['description']),
            "url": @json(route('guides.show', $slug)),
            "datePublished": @json($guide['updated'] ?? '2026-10-12'),
            "dateModified": @json($guide['updated'] ?? '2026-10-12'),
            "author": { "@type": "Person", "name": @json(config('platform.instructor.name')), "url": "{{ route('about') }}" },
            "publisher": {
                "@type": "Organization",
                "name": "{{ config('platform.parent_brand') }}",
                "logo": { "@type": "ImageObject", "url": "{{ asset('assets/logos/patrick_logo.png') }}" }
            },
            "mainEntityOfPage": @json(route('guides.show', $slug))
        },
        {
            "@type": "FAQPage",
            "mainEntity": [{
                "@type": "Question",
                "name": @json($guide['title']),
                "acceptedAnswer": { "@type": "Answer", "text": @json($guide['answer']) }
            }]
        },
        {
            "@type": "BreadcrumbList",
            "itemListElement": [
                { "@type": "ListItem", "position": 1, "name": "Home", "item": "{{ route('home') }}" },
                { "@type": "ListItem", "position": 2, "name": "Guides", "item": "{{ route('guides.index') }}" },
                { "@type": "ListItem", "position": 3, "name": @json($guide['title']), "item": @json(route('guides.show', $slug)) }
            ]
        }
    ]
}
</script>
@endpush

@push('styles')
<style>
.guide-md h2{font-size:1.45rem;margin:1.8rem 0 .6rem;font-weight:700}
.guide-md h3{font-size:1.15rem;margin:1.3rem 0 .4rem;font-weight:700}
.guide-md p{margin:0 0 1rem;line-height:1.8}
.guide-md ul,.guide-md ol{margin:0 0 1.1rem 1.3rem;line-height:1.8}
.guide-md li{margin-bottom:.4rem}
.guide-md strong{color:#0f172a}
.guide-md code{background:rgba(0,0,0,.06);padding:.1rem .35rem;border-radius:4px;font-size:.9em}
.guide-md pre{background:#0f172a;color:#e2e8f0;padding:1rem;border-radius:10px;overflow:auto;margin:0 0 1rem}
.guide-md pre code{background:none;padding:0;color:inherit}
.guide-md table{width:100%;border-collapse:collapse;margin:0 0 1.2rem;font-size:.95em}
.guide-md th,.guide-md td{border:1px solid rgba(0,0,0,.12);padding:.55rem .75rem;text-align:left;vertical-align:top}
.guide-md th{background:rgba(99,102,241,.06)}
.guide-md blockquote{border-left:4px solid var(--ai-primary);margin:0 0 1rem;padding:.5rem 0 .5rem 1rem;background:rgba(99,102,241,.05)}
.guide-md a{color:var(--ai-primary);text-decoration:underline}
.guide-answer{background:rgba(99,102,241,.08);border:1px solid var(--ai-border);border-radius:14px;padding:1.25rem 1.5rem;font-size:1.1rem;line-height:1.7;color:#0f172a}
</style>
@endpush

@section('content')
<section class="ai-section" style="padding-top: 2rem;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <nav aria-label="breadcrumb" class="mb-3">
                    <ol class="breadcrumb small">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('guides.index') }}">Guides</a></li>
                        <li class="breadcrumb-item active">{{ Str::limit($guide['title'], 40) }}</li>
                    </ol>
                </nav>

                <h1 class="fw-bold mb-3">{{ $guide['title'] }}</h1>

                {{-- Direct answer (AEO): the quotable 40-60 word summary --}}
                <div class="guide-answer mb-4">{{ $guide['answer'] }}</div>

                @if($bodyHtml)
                    <article class="guide-md">{!! $bodyHtml !!}</article>
                @endif

                {{-- CTA --}}
                <div class="ai-card p-4 p-lg-5 mt-5 text-center" style="background: var(--ai-gradient); color:#fff;">
                    <h2 class="h4 fw-bold mb-2">Ready to put this into practice?</h2>
                    <p class="mb-4" style="color: rgba(255,255,255,0.85); max-width: 46ch; margin-inline:auto;">
                        Start the free AI Fundamentals course and learn to use AI to earn more — step by step.
                    </p>
                    <a href="{{ auth()->check() ? route('courses.index') : route('register') }}" class="ai-btn" style="background:#fff;color:var(--ai-primary);font-weight:700;"><i class="fas fa-play"></i> Start the Free AI Course</a>
                </div>

                {{-- Related guides --}}
                @if($related->isNotEmpty())
                    <h2 class="h5 fw-bold mt-5 mb-3">Related guides</h2>
                    <div class="row g-3">
                        @foreach($related as $rslug => $rg)
                            <div class="col-md-4">
                                <a href="{{ route('guides.show', $rslug) }}" class="ai-card p-3 h-100 d-block text-decoration-none" style="color: inherit;">
                                    <span class="fw-semibold small">{{ $rg['title'] }}</span>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
