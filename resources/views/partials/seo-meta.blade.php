@php
    $siteName = config('platform.name');
    $siteUrl = rtrim(config('platform.url'), '/');
    $pageTitle = trim($__env->yieldContent('title')) ?: $siteName;
    $description = trim($__env->yieldContent('meta_description')) ?: config('platform.seo.default_description');
    $keywords = trim($__env->yieldContent('meta_keywords')) ?: config('platform.seo.default_keywords');
    $robots = trim($__env->yieldContent('meta_robots')) ?: 'index, follow';
    $canonical = trim($__env->yieldContent('canonical_url')) ?: url()->current();
    $ogType = trim($__env->yieldContent('og_type')) ?: 'website';
    $ogImage = trim($__env->yieldContent('og_image')) ?: asset(config('platform.seo.og_image'));
    if (! str_starts_with($ogImage, 'http')) {
        $ogImage = $siteUrl . '/' . ltrim(parse_url($ogImage, PHP_URL_PATH) ?: $ogImage, '/');
    }
@endphp

<meta name="description" content="{{ $description }}">
<meta name="keywords" content="{{ $keywords }}">
<meta name="robots" content="{{ $robots }}">
<meta name="author" content="{{ config('platform.parent_brand') }}">
<link rel="canonical" href="{{ $canonical }}">

<meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}">
<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:title" content="{{ $pageTitle }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:url" content="{{ $canonical }}">
<meta property="og:type" content="{{ $ogType }}">
<meta property="og:image" content="{{ $ogImage }}">
<meta property="og:image:alt" content="{{ $siteName }} logo">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $pageTitle }}">
<meta name="twitter:description" content="{{ $description }}">
<meta name="twitter:image" content="{{ $ogImage }}">
@if(config('platform.seo.twitter_handle'))
<meta name="twitter:site" content="{{ config('platform.seo.twitter_handle') }}">
@endif

@stack('structured_data')
