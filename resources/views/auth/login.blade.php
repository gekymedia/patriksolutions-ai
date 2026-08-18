@extends('layouts.platform')
@section('title', 'Login — ' . config('platform.name'))

@section('content')
<x-auth-card
    icon="sign-in-alt"
    title="Welcome back"
    subtitle="Sign in to access your AI courses, progress, and AI tutor."
>
    @if (session('status'))
        <div class="alert alert-success py-2 small mb-3">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        @if(request('redirect'))
            <input type="hidden" name="redirect" value="{{ request('redirect') }}">
        @endif

        <div class="mb-3">
            <label for="email" class="ai-form-label">Email</label>
            <input id="email" type="email" name="email" class="ai-form-control" value="{{ old('email') }}" required autofocus autocomplete="username">
            @error('email')<div class="ai-form-error">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="password" class="ai-form-label">Password</label>
            <input id="password" type="password" name="password" class="ai-form-control" required autocomplete="current-password">
            @error('password')<div class="ai-form-error">{{ $message }}</div>@enderror
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <label class="ai-form-check">
                <input type="checkbox" name="remember" id="remember_me">
                Remember me
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="ai-auth-link">Forgot password?</a>
            @endif
        </div>

        <button type="submit" class="ai-btn ai-btn-primary w-100 justify-content-center">
            <i class="fas fa-sign-in-alt"></i> Log in
        </button>
    </form>

    <div class="ai-auth-divider">or</div>

    <a href="{{ route('membership.index') }}" class="ai-btn ai-btn-dark w-100 justify-content-center">
        <i class="fas fa-crown"></i> View membership plans
    </a>

    <x-slot:footer>
        Don't have an account?
        <a href="{{ route('register', request()->only('redirect')) }}" class="ai-auth-link">Create one free</a>
    </x-slot:footer>
</x-auth-card>
@endsection
