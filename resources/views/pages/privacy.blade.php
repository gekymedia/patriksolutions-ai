@extends('layouts.platform')
@section('title', 'Privacy Policy — ' . config('platform.name'))
@section('meta_description', 'How Patrik Solutions AI collects, uses, and protects your data — account details, payments, course progress, cookies, your rights, and how to contact us.')
@section('canonical_url', route('privacy'))
@section('meta_robots', 'index, follow')

@php
    $entity = config('platform.legal.entity');
    $jurisdiction = config('platform.legal.jurisdiction');
    $effective = config('platform.legal.effective_date');
    $email = config('platform.contact.email');
@endphp

@section('content')
<section class="ai-section" style="padding-top: 3rem;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <h1 class="fw-bold mb-1">Privacy Policy</h1>
                <p class="text-muted small mb-4">Effective date: {{ $effective }}</p>

                <div class="ai-card p-4 p-lg-5 lesson-md">
                    <p>This Privacy Policy explains how {{ $entity }} ("we", "us", "our") collects, uses, and protects your
                    information when you use {{ config('platform.name') }} (the "Service"). By using the Service, you agree
                    to this policy.</p>

                    <h2>1. Information we collect</h2>
                    <ul>
                        <li><strong>Account information:</strong> your name, email address, and password (stored encrypted).</li>
                        <li><strong>Payment information:</strong> handled by our payment processor (Stripe). We do not see or
                        store your full card number — Stripe processes payments on our behalf.</li>
                        <li><strong>Learning activity:</strong> courses you enrol in, lesson progress, and questions you ask
                        the AI tutor.</li>
                        <li><strong>Technical data:</strong> basic log and device information and cookies needed to keep you
                        signed in and the Service secure.</li>
                    </ul>

                    <h2>2. How we use your information</h2>
                    <ul>
                        <li>To provide the Service — your account, courses, progress tracking, and the AI tutor.</li>
                        <li>To process payments and manage your membership.</li>
                        <li>To send essential account and service messages, and (with your consent) updates and offers.</li>
                        <li>To improve our courses and keep the Service safe and reliable.</li>
                    </ul>

                    <h2>3. How we share information</h2>
                    <p>We do not sell your personal data. We share it only with trusted providers who help us run the
                    Service — for example our payment processor (Stripe), hosting provider, and email provider — and only as
                    needed. We may also disclose information if required by law.</p>

                    <h2>4. Cookies</h2>
                    <p>We use essential cookies to keep you logged in and protect against fraud (for example session and
                    CSRF tokens). These are necessary for the Service to work.</p>

                    <h2>5. Data retention</h2>
                    <p>We keep your information for as long as your account is active or as needed to provide the Service and
                    meet legal obligations. You can ask us to delete your account and associated personal data.</p>

                    <h2>6. Your rights</h2>
                    <p>You can access, correct, or delete your personal information, and object to or restrict certain
                    processing. To exercise these rights, email us at <a href="mailto:{{ $email }}">{{ $email }}</a>. You can
                    manage or delete your account from your profile settings at any time.</p>

                    <h2>7. Security</h2>
                    <p>We use reasonable technical and organisational measures to protect your data, including encryption in
                    transit (HTTPS) and encrypted passwords. No method of transmission or storage is 100% secure, but we work
                    to protect your information.</p>

                    <h2>8. Children</h2>
                    <p>The Service is not intended for anyone under 18. We do not knowingly collect data from children.</p>

                    <h2>9. Changes</h2>
                    <p>We may update this policy from time to time and will post the new version here with an updated
                    effective date.</p>

                    <h2>10. Contact</h2>
                    <p>Questions about your privacy or this policy? Email us at <a href="mailto:{{ $email }}">{{ $email }}</a>.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
