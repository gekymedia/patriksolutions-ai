@extends('layouts.platform')
@section('title', 'Verify Email — ' . config('platform.name'))

@section('content')
<x-auth-card
    icon="envelope"
    title="Verify your email"
    subtitle="Thanks for signing up! Before getting started, please verify your email address by clicking the link we sent you."
>
    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success py-2 small mb-3">
            A new verification link has been sent to your email address.
        </div>
    @endif

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="ai-btn ai-btn-primary w-100 justify-content-center mb-3">
            <i class="fas fa-paper-plane"></i> Resend verification email
        </button>
    </form>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="ai-btn ai-btn-dark w-100 justify-content-center">
            <i class="fas fa-sign-out-alt"></i> Log out
        </button>
    </form>
</x-auth-card>
@endsection
