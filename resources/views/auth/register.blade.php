@extends('layouts.platform')
@section('title', 'Create Account — ' . config('platform.name'))

@section('content')
<x-auth-card
    icon="user-plus"
    title="Create your account"
    subtitle="Join Patrik Solutions AI and start learning practical skills today."
>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        @if(request('redirect'))
            <input type="hidden" name="redirect" value="{{ request('redirect') }}">
        @endif

        <div class="mb-3">
            <label for="name" class="ai-form-label">Full name</label>
            <input id="name" type="text" name="name" class="ai-form-control" value="{{ old('name') }}" required autofocus autocomplete="name">
            @error('name')<div class="ai-form-error">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="email" class="ai-form-label">Email</label>
            <input id="email" type="email" name="email" class="ai-form-control" value="{{ old('email') }}" required autocomplete="username">
            @error('email')<div class="ai-form-error">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="password" class="ai-form-label">Password</label>
            <input id="password" type="password" name="password" class="ai-form-control" required autocomplete="new-password">
            @error('password')<div class="ai-form-error">{{ $message }}</div>@enderror
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="ai-form-label">Confirm password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" class="ai-form-control" required autocomplete="new-password">
            @error('password_confirmation')<div class="ai-form-error">{{ $message }}</div>@enderror
        </div>

        <button type="submit" class="ai-btn ai-btn-primary w-100 justify-content-center">
            <i class="fas fa-rocket"></i> Create account
        </button>
    </form>

    <p class="text-center small text-muted mt-3 mb-0">
        By signing up you agree to our terms. Course access may require an active membership.
    </p>

    <x-slot:footer>
        Already have an account?
        <a href="{{ route('login', request()->only('redirect')) }}" class="ai-auth-link">Log in</a>
    </x-slot:footer>
</x-auth-card>
@endsection
