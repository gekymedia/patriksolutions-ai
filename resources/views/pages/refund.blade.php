@extends('layouts.platform')
@section('title', 'Refund Policy — ' . config('platform.name'))
@section('meta_description', 'Our refund promise: a money-back guarantee on your first payment for any paid plan, plus how cancellation works. Simple, fair, and clearly explained.')
@section('canonical_url', route('refund'))
@section('meta_robots', 'index, follow')

@php
    $entity = config('platform.legal.entity');
    $effective = config('platform.legal.effective_date');
    $refundDays = config('platform.legal.refund_days');
    $email = config('platform.contact.email');
@endphp

@section('content')
<section class="ai-section" style="padding-top: 3rem;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <h1 class="fw-bold mb-1">Refund Policy</h1>
                <p class="text-muted small mb-4">Effective date: {{ $effective }}</p>

                <div class="alert" style="background: rgba(99,102,241,0.08); border: 1px solid var(--ai-border); border-radius: 14px;">
                    <h2 class="h5 fw-bold mb-1"><i class="fas fa-shield-heart me-2" style="color: var(--ai-primary);"></i>Our {{ $refundDays }}-day money-back guarantee</h2>
                    <p class="mb-0 text-muted">Try any paid plan risk-free. If it's not for you, email us within {{ $refundDays }} days of your first payment and we'll refund it — no hard feelings.</p>
                </div>

                <div class="ai-card p-4 p-lg-5 lesson-md">
                    <h2>1. The free course is free</h2>
                    <p>The AI Fundamentals course is free to enrol with a free account — there's nothing to refund.</p>

                    <h2>2. Money-back guarantee on paid plans</h2>
                    <p>When you start a paid plan (AI Member or AI Pro) for the first time, you're covered by a
                    {{ $refundDays }}-day money-back guarantee. If you're not happy, contact us within {{ $refundDays }} days
                    of that first charge and we'll refund it in full.</p>

                    <h2>3. How to request a refund</h2>
                    <p>Email <a href="mailto:{{ $email }}">{{ $email }}</a> from the email address on your account and include
                    the plan you're on. We'll process eligible refunds to your original payment method, usually within 5–10
                    business days (your bank may take a little longer to show it).</p>

                    <h2>4. Cancelling your membership</h2>
                    <p>You can cancel anytime from your account. When you cancel, you keep access until the end of your
                    current billing period, and you won't be charged again. Cancelling stops future payments but is separate
                    from a refund request.</p>

                    <h2>5. Renewals after the guarantee window</h2>
                    <p>Because you can cancel at any time to prevent the next charge, monthly renewal payments made after your
                    initial {{ $refundDays }}-day window are generally non-refundable, except where required by law. If
                    something went wrong — a technical issue or an accidental charge — email us and we'll make it right.</p>

                    <h2>6. Contact</h2>
                    <p>Questions about a refund? Email <a href="mailto:{{ $email }}">{{ $email }}</a> and we'll help.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
