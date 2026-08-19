@extends('layouts.platform')
@section('title', 'Reset Password — ' . config('platform.name'))
@section('meta_robots', 'noindex, nofollow')

@section('content')
<x-auth-card
    icon="lock"
    title="Set new password"
    subtitle="Choose a strong password for your account."
>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="mb-3">
            <label for="email" class="ai-form-label">Email</label>
            <input id="email" type="email" name="email" class="ai-form-control" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username">
            @error('email')<div class="ai-form-error">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="password" class="ai-form-label">New password</label>
            <input id="password" type="password" name="password" class="ai-form-control" required autocomplete="new-password">
            @error('password')<div class="ai-form-error">{{ $message }}</div>@enderror
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="ai-form-label">Confirm password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" class="ai-form-control" required autocomplete="new-password">
            @error('password_confirmation')<div class="ai-form-error">{{ $message }}</div>@enderror
        </div>

        <button type="submit" class="ai-btn ai-btn-primary w-100 justify-content-center">
            <i class="fas fa-check"></i> Reset password
        </button>
    </form>
</x-auth-card>
@endsection
