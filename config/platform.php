<?php

return [

    'name' => env('APP_NAME', 'Patrik Solutions AI'),

    'tagline' => env('APP_TAGLINE', 'Master AI skills with expert-led courses'),

    'url' => env('APP_URL', 'https://ai.patriksolutions.com'),

    'parent_brand' => env('PARENT_BRAND', 'Patrik Solutions'),

    'parent_url' => env('PARENT_SITE_URL', 'https://patriksolutions.com'),

    'seo' => [
        'default_description' => env(
            'APP_SEO_DESCRIPTION',
            'Master practical AI skills with expert-led courses, an AI tutor, and progress tracking. Learn artificial intelligence, build wealth, and shape the future with Patrik Solutions.'
        ),
        'default_keywords' => env(
            'APP_SEO_KEYWORDS',
            'AI courses, artificial intelligence training, machine learning, AI tutor, online AI learning, Patrik Solutions AI'
        ),
        'og_image' => 'assets/logos/patrick_logo.png',
        'twitter_handle' => env('TWITTER_HANDLE'),
    ],

];
