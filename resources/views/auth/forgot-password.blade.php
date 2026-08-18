@extends('layouts.platform')
@section('title', 'Forgot Password — ' . config('platform.name'))

@section('content')
<x-auth-card
    icon="key"
    title="Forgot password?"
    subtitle="No worries. Enter your email and we'll send you a reset link."
>
    @if (session('status'))
        <div class="alert alert-success py-2 small mb-3">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-4">
            <label for="email" class="ai-form-label">Email</label>
            <input id="email" type="email" name="email" class="ai-form-control" value="{{ old('email') }}" required autofocus autocomplete="username">
            @error('email')<div class="ai-form-error">{{ $message }}</div>@enderror
        </div>

        <button type="submit" class="ai-btn ai-btn-primary w-100 justify-content-center">
            <i class="fas fa-paper-plane"></i> Send reset link
        </button>
    </form>

    <x-slot:footer>
        Remember your password?
        <a href="{{ route('login') }}" class="ai-auth-link">Back to login</a>
    </x-slot:footer>
</x-auth-card>
@endsection
