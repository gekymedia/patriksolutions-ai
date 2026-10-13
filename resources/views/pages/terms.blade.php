@extends('layouts.platform')
@section('title', 'Terms of Service — ' . config('platform.name'))
@section('meta_description', 'The terms that govern your use of Patrik Solutions AI — accounts, membership and billing, acceptable use, course content, and disclaimers.')
@section('canonical_url', route('terms'))
@section('meta_robots', 'index, follow')

@php
    $entity = config('platform.legal.entity');
    $jurisdiction = config('platform.legal.jurisdiction');
    $effective = config('platform.legal.effective_date');
    $refundDays = config('platform.legal.refund_days');
    $email = config('platform.contact.email');
@endphp

@section('content')
<section class="ai-section" style="padding-top: 3rem;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <h1 class="fw-bold mb-1">Terms of Service</h1>
                <p class="text-muted small mb-4">Effective date: {{ $effective }}</p>

                <div class="ai-card p-4 p-lg-5 lesson-md">
                    <p>These Terms of Service ("Terms") govern your access to and use of {{ config('platform.name') }}
                    (the "Service"), operated by {{ $entity }} ("we", "us", "our"). By creating an account or using the
                    Service, you agree to these Terms. If you do not agree, please do not use the Service.</p>

                    <h2>1. Accounts</h2>
                    <p>You must provide accurate information when you register and keep your login details secure. You are
                    responsible for all activity under your account. You must be at least 18 years old, or the age of
                    majority where you live, to create an account.</p>

                    <h2>2. Membership &amp; billing</h2>
                    <p>Some courses and features require a paid membership (currently AI Member and AI Pro). Paid plans are
                    billed in advance on a recurring monthly basis through our payment processor until you cancel. By
                    subscribing, you authorise us to charge your chosen payment method for each billing cycle.</p>
                    <p>You can cancel at any time from your account. When you cancel, you keep access until the end of your
                    current paid period, and you will not be charged again. Refunds are handled under our
                    <a href="{{ route('refund') }}">Refund Policy</a>, which offers a {{ $refundDays }}-day money-back
                    guarantee on your first payment for a paid plan.</p>

                    <h2>3. Free account</h2>
                    <p>A free account gives you access to the free AI Fundamentals course, progress tracking, and preview
                    lessons from other courses. Free features are provided "as is" and may change over time.</p>

                    <h2>4. Course content &amp; licence</h2>
                    <p>All course materials, lessons, text, graphics, and other content are owned by {{ $entity }} or its
                    licensors and are protected by law. We grant you a personal, non-transferable, non-exclusive licence to
                    access and use the content for your own learning. You may not copy, resell, share, publish, or
                    redistribute the content, or share your account, without our written permission.</p>

                    <h2>5. AI tutor</h2>
                    <p>The AI tutor is an automated assistant that can make mistakes. Its responses are for learning support
                    only and are not professional, legal, financial, or tax advice. Always verify important information.</p>

                    <h2>6. No income or results guarantee</h2>
                    <p>Our courses teach skills to help you use AI effectively. We do not promise or guarantee any specific
                    income, earnings, job, or other result. Your outcomes depend on your own effort, circumstances, and many
                    factors outside our control.</p>

                    <h2>7. Acceptable use</h2>
                    <p>You agree not to misuse the Service, including: attempting to access content you have not paid for,
                    sharing or reselling materials, disrupting the Service, scraping or automated data collection, or using
                    the Service for anything unlawful.</p>

                    <h2>8. Third-party tools</h2>
                    <p>Our courses may reference third-party AI tools (such as ChatGPT, Claude, or Gemini). Those tools are
                    provided by their own companies under their own terms and are not included in your membership.</p>

                    <h2>9. Disclaimers &amp; limitation of liability</h2>
                    <p>The Service is provided "as is" without warranties of any kind. To the fullest extent permitted by
                    law, {{ $entity }} is not liable for any indirect, incidental, or consequential damages, and our total
                    liability is limited to the amount you paid us in the 12 months before the claim.</p>

                    <h2>10. Changes</h2>
                    <p>We may update these Terms from time to time. We will post the updated Terms here with a new effective
                    date. Continued use of the Service after changes means you accept the updated Terms.</p>

                    <h2>11. Governing law</h2>
                    <p>These Terms are governed by the laws of {{ $jurisdiction }}, without regard to conflict-of-law rules.</p>

                    <h2>12. Contact</h2>
                    <p>Questions about these Terms? Email us at <a href="mailto:{{ $email }}">{{ $email }}</a>.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
