<?php

return [

    'name' => env('APP_NAME', 'Patrik Solutions AI'),

    'tagline' => env('APP_TAGLINE', 'Use AI to earn more, work faster, and build modern skills'),

    'url' => env('APP_URL', 'https://ai.patriksolutions.com'),

    'parent_brand' => env('PARENT_BRAND', 'Patrik Solutions'),

    'parent_url' => env('PARENT_SITE_URL', 'https://patriksolutions.com'),

    /*
    |--------------------------------------------------------------------------
    | Entity sentence (AEO)
    |--------------------------------------------------------------------------
    | One clear "who we are / who we serve" sentence reused across the site and
    | in structured data so answer engines (ChatGPT, Perplexity, Google AI) can
    | describe and cite us accurately.
    */
    'entity_sentence' => env(
        'PLATFORM_ENTITY',
        'Patrik Solutions AI teaches people in Ghana, across the diaspora, and worldwide to use AI to earn more, work faster, and build practical, modern skills — led by AIGP-certified AI engineer and instructor Patrik Barfi.'
    ),

    /*
    |--------------------------------------------------------------------------
    | Instructor / founder (AEO + trust)
    |--------------------------------------------------------------------------
    */
    'instructor' => [
        'name'        => 'Patrik Barfi',
        'role'        => 'AI Engineer, AI Instructor & Personal Financial Advisor',
        'credentials' => 'AIGP (AI Governance Professional) · BSc Artificial Intelligence Applications',
        'short_bio'   => 'Patrik Barfi is an AI engineer and instructor who builds real AI agents and automations, and a personal financial advisor. He founded Patrik Solutions to help everyday people — in Ghana, across the diaspora, and worldwide — use AI to earn more and work smarter.',
        // Drop a real headshot at public/assets/instructor/patrik-barfi.jpg to replace the fallback avatar.
        'photo'       => 'assets/instructor/patrik-barfi.jpg',
        'youtube'     => env('INSTRUCTOR_YOUTUBE', 'https://www.youtube.com/@patrikbarfi'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Contact (SEO/AEO: ONE email, ONE phone/WhatsApp)
    |--------------------------------------------------------------------------
    | Set CONTACT_WHATSAPP in .env to your full international number (digits only,
    | e.g. 233XXXXXXXXX). Leave blank to hide the WhatsApp link until it's ready.
    */
    'contact' => [
        'email'         => env('CONTACT_EMAIL', 'patriksolutions@gmail.com'),
        'whatsapp'      => env('CONTACT_WHATSAPP', ''),            // digits only, no + or spaces
        'whatsapp_label'=> env('CONTACT_WHATSAPP_LABEL', ''),      // pretty label e.g. +233 20 000 0000
    ],

    /*
    |--------------------------------------------------------------------------
    | Pricing (single source of truth for copy)
    |--------------------------------------------------------------------------
    */
    'prices' => [
        'free'  => 0,
        'pro'   => 19,   // AI Member
        'elite' => 49,   // AI Pro
    ],

    /*
    |--------------------------------------------------------------------------
    | Legal (Terms / Privacy / Refund pages)
    |--------------------------------------------------------------------------
    | Confirm the registered/legal entity name and country with your own records
    | (and ideally a lawyer) before publishing these as binding policy.
    */
    'legal' => [
        'entity'         => env('LEGAL_ENTITY', 'Patrik Solutions'),
        'jurisdiction'   => env('LEGAL_JURISDICTION', 'Ghana'),
        'effective_date' => env('LEGAL_EFFECTIVE_DATE', 'October 12, 2026'),
        'refund_days'    => (int) env('REFUND_DAYS', 14),
    ],

    /*
    |--------------------------------------------------------------------------
    | Testimonials (trust)
    |--------------------------------------------------------------------------
    | Add REAL, named testimonials only. The testimonials section renders on the
    | homepage automatically once this array has entries — until then it stays
    | hidden (no fake/empty social proof shown live). Example entry:
    |   ['quote' => '...', 'name' => 'Ama O.', 'detail' => 'Freelancer, Accra'],
    */
    'testimonials' => [],

    'seo' => [
        'default_description' => env(
            'APP_SEO_DESCRIPTION',
            'Learn to make money with AI through practical, expert-led courses — built for Ghana, the diaspora, and anyone worldwide who wants to earn more and work smarter with AI.'
        ),
        'default_keywords' => env(
            'APP_SEO_KEYWORDS',
            'make money with AI, AI courses, AI for business, AI skills, AI training Ghana, AI for the diaspora, learn AI online, Patrik Solutions AI'
        ),
        // TODO: replace with a real 1200x630 share image at public/assets/og/share.png (audit item S6).
        'og_image' => env('APP_OG_IMAGE', 'assets/logos/patrick_logo.png'),
        'twitter_handle' => env('TWITTER_HANDLE'),
    ],

];
