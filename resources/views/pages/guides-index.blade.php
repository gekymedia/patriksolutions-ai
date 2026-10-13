@extends('layouts.platform')
@section('title', 'AI Guides — Make Money With AI, Tools & Prompts | ' . config('platform.name'))
@section('meta_description', 'Free, practical guides on making money with AI, the best free AI tools, writing prompts, AI side-hustles and more — for Ghana, the diaspora and beyond.')
@section('canonical_url', route('guides.index'))

@push('structured_data')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "CollectionPage",
    "name": "AI Guides",
    "url": "{{ route('guides.index') }}",
    "description": "Practical guides on making money with AI, AI tools, and AI skills.",
    "publisher": { "@type": "Organization", "name": "{{ config('platform.parent_brand') }}", "url": "{{ config('platform.url') }}" },
    "hasPart": [
        @foreach($guides as $slug => $g)
        {
            "@type": "Article",
            "headline": @json($g['title']),
            "url": @json(route('guides.show', $slug)),
            "description": @json($g['description'])
        }@if(!$loop->last),@endif
        @endforeach
    ]
}
</script>
@endpush

@section('content')
<section class="ai-section" style="padding-top: 3rem;">
    <div class="container">
        <div class="ai-badge mb-3"><i class="fas fa-book-open"></i> Guides</div>
        <h1 class="ai-section-title text-start">AI guides: make money, work smarter, use AI well</h1>
        <p class="text-muted" style="max-width: 65ch;">
            Free, practical guides for beginners — how to earn with AI, the best tools, writing prompts, and more.
            Built for Ghana and the diaspora, useful anywhere.
        </p>

        <div class="row g-4 mt-2">
            @foreach($guides as $slug => $g)
                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('guides.show', $slug) }}" class="ai-card p-4 h-100 d-block text-decoration-none" style="color: inherit;">
                        <i class="fas fa-file-lines mb-2" style="color: var(--ai-primary); font-size: 1.25rem;"></i>
                        <h2 class="h6 fw-bold">{{ $g['title'] }}</h2>
                        <p class="small text-muted mb-3">{{ $g['description'] }}</p>
                        <span class="fw-semibold small" style="color: var(--ai-primary);">Read guide <i class="fas fa-arrow-right ms-1"></i></span>
                    </a>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-5">
            <a href="{{ auth()->check() ? route('courses.index') : route('register') }}" class="ai-btn ai-btn-primary btn-lg"><i class="fas fa-play"></i> Start the Free AI Course</a>
        </div>
    </div>
</section>
@endsection
