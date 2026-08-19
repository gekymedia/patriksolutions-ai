@extends('layouts.platform')
@section('title', 'Confirm Password — ' . config('platform.name'))
@section('meta_robots', 'noindex, nofollow')

@section('content')
<x-auth-card
    icon="shield-alt"
    title="Confirm password"
    subtitle="This is a secure area. Please confirm your password before continuing."
>
    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <div class="mb-4">
            <label for="password" class="ai-form-label">Password</label>
            <input id="password" type="password" name="password" class="ai-form-control" required autocomplete="current-password">
            @error('password')<div class="ai-form-error">{{ $message }}</div>@enderror
        </div>

        <button type="submit" class="ai-btn ai-btn-primary w-100 justify-content-center">
            <i class="fas fa-check"></i> Confirm
        </button>
    </form>
</x-auth-card>
@endsection
