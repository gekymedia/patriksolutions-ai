@extends('layouts.platform')
@section('title', 'Profile — ' . config('platform.name'))
@section('meta_robots', 'noindex, nofollow')

@section('content')
<section class="ai-section" style="padding-top: 3rem;">
    <div class="container" style="max-width: 720px;">
        <h1 class="ai-section-title mb-4">Account settings</h1>

        @include('profile.partials.update-profile-information-form')
        @include('profile.partials.update-password-form')
        @include('profile.partials.delete-user-form')
    </div>
</section>
@endsection
