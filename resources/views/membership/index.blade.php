@extends('layouts.platform')
@section('title', 'Become a Member — ' . config('platform.name'))

@push('head')
@if(auth()->check() && $stripeConfigured)
<script src="https://js.stripe.com/v3/"></script>
@endif
@endpush

@push('styles')
<style>
    .membership-plan-card { height: 100%; display: flex; flex-direction: column; }
    .membership-plan-card.is-current { border: 2px solid var(--ai-primary); box-shadow: var(--ai-glow); }
    .membership-plan-card.is-featured { border: 2px solid var(--ai-primary); position: relative; }
    .membership-price { font-size: 2.5rem; font-weight: 800; line-height: 1; letter-spacing: -0.03em; }
    .membership-price span { font-size: 1rem; font-weight: 500; color: var(--ai-muted); }
    .membership-features { list-style: none; padding: 0; margin: 0 0 1.5rem; flex-grow: 1; }
    .membership-features li { display: flex; align-items: flex-start; gap: 0.75rem; padding: 0.5rem 0; color: var(--ai-muted); line-height: 1.5; }
    .membership-features li.included { color: #0f172a; }
    .membership-features li i { margin-top: 0.2rem; width: 1rem; text-align: center; }
    #membership-card-errors { color: #ef4444; font-size: 0.9rem; min-height: 1.25rem; }
    #membership-card-element { padding: 0.875rem; border: 1px solid var(--ai-border); border-radius: 12px; background: #fff; margin-bottom: 1rem; }
    .plan-icon { width: 56px; height: 56px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: #fff; margin: 0 auto 1rem; background: var(--ai-gradient); }
</style>
@endpush

@section('content')
<section class="ai-section" style="padding-top: 3rem;">
    <div class="container">
        @if(session('upgrade_message'))
            <div class="alert alert-warning alert-dismissible fade show">
                <i class="fas fa-lock me-2"></i>{{ session('upgrade_message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @unless($stripeConfigured)
            <div class="alert alert-info alert-dismissible fade show">
                <i class="fas fa-info-circle me-2"></i>
                Online checkout is not active yet. Plan details are shown below; payment setup is still in progress.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endunless

        <div class="text-center mb-5">
            <div class="ai-badge mb-3"><i class="fas fa-crown"></i> Become a Member</div>
            <h1 class="ai-section-title">Join &amp; Start Learning AI</h1>
            <p class="ai-section-subtitle mx-auto" style="max-width: 640px;">
                Choose a plan to unlock all AI courses, your personal AI tutor on every lesson, and progress tracking.
            </p>
        </div>

        <div class="row g-4 align-items-stretch">
            {{-- Free --}}
            <div class="col-lg-4">
                <div class="ai-card membership-plan-card p-4 {{ $currentPlan === 'free' ? 'is-current' : '' }}">
                    <div class="text-center mb-4">
                        <div class="plan-icon" style="background: linear-gradient(135deg, #64748b, #94a3b8);"><i class="fas fa-user"></i></div>
                        <h3 class="fw-bold mb-2">Free Account</h3>
                        <div class="membership-price">$0<span>/mo</span></div>
                    </div>
                    <ul class="membership-features">
                        <li class="included"><i class="fas fa-check text-success"></i> Browse course catalog</li>
                        <li class="included"><i class="fas fa-check text-success"></i> Create a student account</li>
                        <li><i class="fas fa-times text-muted"></i> Enroll in courses</li>
                        <li><i class="fas fa-times text-muted"></i> AI tutor access</li>
                        <li><i class="fas fa-times text-muted"></i> Progress tracking</li>
                    </ul>
                    @if(auth()->check() && $currentPlan === 'free')
                        <button class="ai-btn ai-btn-dark w-100 justify-content-center" disabled>Current plan</button>
                    @elseif(! auth()->check())
                        <a href="{{ route('register', ['redirect' => route('membership.index')]) }}" class="ai-btn ai-btn-dark w-100 justify-content-center">
                            <i class="fas fa-user-plus"></i> Sign up free
                        </a>
                    @endif
                </div>
            </div>

            {{-- Pro / AI Member --}}
            <div class="col-lg-4">
                <div class="ai-card membership-plan-card p-4 is-featured {{ $currentPlan === 'pro' ? 'is-current' : '' }}">
                    <div class="text-center mb-2">
                        <span class="badge rounded-pill mb-3" style="background: var(--ai-gradient);">Most popular</span>
                    </div>
                    <div class="text-center mb-4">
                        <div class="plan-icon"><i class="fas fa-graduation-cap"></i></div>
                        <h3 class="fw-bold mb-2">AI Member</h3>
                        <div class="membership-price">$19<span>/mo</span></div>
                    </div>
                    <ul class="membership-features">
                        <li class="included"><i class="fas fa-check text-success"></i> All AI courses</li>
                        <li class="included"><i class="fas fa-check text-success"></i> AI tutor on every lesson</li>
                        <li class="included"><i class="fas fa-check text-success"></i> Progress tracking</li>
                        <li class="included"><i class="fas fa-check text-success"></i> 50 AI tutor questions/day</li>
                        <li class="included"><i class="fas fa-check text-success"></i> Monthly live Zoom Q&amp;A</li>
                        <li><i class="fas fa-times text-muted"></i> Priority tutor responses</li>
                    </ul>
                    @if(auth()->check() && $currentPlan === 'pro')
                        <button class="ai-btn ai-btn-dark w-100 justify-content-center" disabled>Current plan</button>
                    @elseif(! auth()->check() || $currentPlan !== 'elite')
                        @if($stripeConfigured && auth()->check())
                            <button type="button" class="ai-btn ai-btn-primary w-100 justify-content-center"
                                onclick="startCheckout('pro', '{{ config('cashier.key') }}', '{{ $intent->client_secret }}')">
                                <i class="fas fa-credit-card"></i> Join — $19/mo
                            </button>
                        @elseif($stripeConfigured)
                            <a href="{{ route('login', ['redirect' => route('membership.index', ['plan' => 'pro'])]) }}" class="ai-btn ai-btn-primary w-100 justify-content-center">
                                <i class="fas fa-sign-in-alt"></i> Log in to join
                            </a>
                        @else
                            <button class="ai-btn ai-btn-primary w-100 justify-content-center" disabled>Coming soon</button>
                        @endif
                    @endif
                </div>
            </div>

            {{-- Elite / AI Pro --}}
            <div class="col-lg-4">
                <div class="ai-card membership-plan-card p-4 {{ $currentPlan === 'elite' ? 'is-current' : '' }}">
                    <div class="text-center mb-4">
                        <div class="plan-icon" style="background: linear-gradient(135deg, #f59e0b, #ef4444);"><i class="fas fa-crown"></i></div>
                        <h3 class="fw-bold mb-2">AI Pro</h3>
                        <div class="membership-price">$49<span>/mo</span></div>
                    </div>
                    <ul class="membership-features">
                        <li class="included"><i class="fas fa-check text-success"></i> Everything in AI Member</li>
                        <li class="included"><i class="fas fa-check text-success"></i> 100 AI tutor questions/day</li>
                        <li class="included"><i class="fas fa-check text-success"></i> Priority AI responses</li>
                        <li class="included"><i class="fas fa-check text-success"></i> 1-on-1 monthly coaching call</li>
                        <li class="included"><i class="fas fa-check text-success"></i> Early access to new courses</li>
                        <li class="included"><i class="fas fa-check text-success"></i> Direct instructor support</li>
                    </ul>
                    @if(auth()->check() && $currentPlan === 'elite')
                        <button class="ai-btn ai-btn-dark w-100 justify-content-center" disabled>Current plan</button>
                    @else
                        @if($stripeConfigured && auth()->check())
                            <button type="button" class="ai-btn ai-btn-primary w-100 justify-content-center"
                                onclick="startCheckout('elite', '{{ config('cashier.key') }}', '{{ $intent->client_secret }}')">
                                <i class="fas fa-crown"></i> Join — $49/mo
                            </button>
                        @elseif($stripeConfigured)
                            <a href="{{ route('login', ['redirect' => route('membership.index', ['plan' => 'elite'])]) }}" class="ai-btn ai-btn-primary w-100 justify-content-center">
                                <i class="fas fa-sign-in-alt"></i> Log in to join
                            </a>
                        @else
                            <button class="ai-btn ai-btn-primary w-100 justify-content-center" disabled>Coming soon</button>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        @if(auth()->check() && $currentPlan !== 'free')
            <div class="ai-card p-4 mt-4">
                <h4 class="fw-bold mb-3"><i class="fas fa-cog me-2" style="color: var(--ai-primary);"></i>Manage Subscription</h4>
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('membership.billing') }}" class="ai-btn ai-btn-dark">
                        <i class="fas fa-credit-card"></i> Billing &amp; invoices
                    </a>
                    @if(auth()->user()->subscription('default') && !auth()->user()->subscription('default')->cancelled())
                        <button type="button" onclick="cancelSubscription()" class="ai-btn" style="background: rgba(239,68,68,0.1); color: #ef4444; border: 1px solid rgba(239,68,68,0.2);">
                            <i class="fas fa-times"></i> Cancel subscription
                        </button>
                    @elseif(auth()->user()->subscription('default') && auth()->user()->subscription('default')->onGracePeriod())
                        <button type="button" onclick="resumeSubscription()" class="ai-btn ai-btn-primary">
                            <i class="fas fa-redo"></i> Resume subscription
                        </button>
                    @endif
                </div>
            </div>
        @endif
    </div>
</section>

@if(auth()->check() && $stripeConfigured)
<div class="modal fade" id="paymentModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel"><i class="fas fa-credit-card me-2"></i>Complete your membership</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted mb-3">Enter your card details to start your subscription and unlock all courses.</p>
                <div id="membership-card-element"></div>
                <div id="membership-card-errors" class="mb-2"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="membership-pay-btn" class="ai-btn ai-btn-primary" onclick="confirmPayment()">
                    <span id="membership-pay-label">Confirm &amp; Subscribe</span>
                </button>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
@if(auth()->check() && $stripeConfigured)
<script>
let stripe, cardElement, selectedPlan, setupClientSecret, paymentModal;

document.addEventListener('DOMContentLoaded', function () {
    paymentModal = new bootstrap.Modal(document.getElementById('paymentModal'));
    @if($checkoutPlan && $intent)
    startCheckout('{{ $checkoutPlan }}', '{{ config('cashier.key') }}', '{{ $intent->client_secret }}');
    @endif
});

function startCheckout(plan, stripeKey, clientSecret) {
    selectedPlan = plan;
    setupClientSecret = clientSecret;
    stripe = Stripe(stripeKey);
    document.getElementById('paymentModalLabel').innerHTML = plan === 'pro'
        ? '<i class="fas fa-graduation-cap me-2"></i>AI Member — $19/mo'
        : '<i class="fas fa-crown me-2"></i>AI Pro — $49/mo';
    document.getElementById('membership-card-errors').textContent = '';
    if (cardElement) { cardElement.unmount(); cardElement = null; }
    cardElement = stripe.elements().create('card', { style: { base: { fontSize: '16px', color: '#111827' } } });
    cardElement.mount('#membership-card-element');
    cardElement.on('change', ({ error }) => {
        document.getElementById('membership-card-errors').textContent = error ? error.message : '';
    });
    paymentModal.show();
}

async function confirmPayment() {
    const btn = document.getElementById('membership-pay-btn');
    const label = document.getElementById('membership-pay-label');
    btn.disabled = true;
    label.textContent = 'Processing...';
    const { setupIntent, error } = await stripe.confirmCardSetup(setupClientSecret, { payment_method: { card: cardElement } });
    if (error) {
        document.getElementById('membership-card-errors').textContent = error.message;
        btn.disabled = false;
        label.textContent = 'Confirm & Subscribe';
        return;
    }
    const res = await fetch('{{ route("membership.subscribe") }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify({ plan: selectedPlan, payment_method: setupIntent.payment_method })
    });
    const data = await res.json();
    if (data.success) {
        window.location.href = '{{ route("courses.index") }}';
    } else {
        document.getElementById('membership-card-errors').textContent = data.message || 'Payment failed.';
        btn.disabled = false;
        label.textContent = 'Confirm & Subscribe';
    }
}

async function cancelSubscription() {
    if (!confirm('Cancel your subscription? You keep access until the end of the billing period.')) return;
    const res = await fetch('{{ route("membership.cancel") }}', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });
    const data = await res.json();
    if (data.success) window.location.reload();
}

async function resumeSubscription() {
    const res = await fetch('{{ route("membership.resume") }}', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });
    const data = await res.json();
    if (data.success) window.location.reload();
}
</script>
@endif
@endpush
