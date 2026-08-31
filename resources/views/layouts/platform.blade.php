<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('platform.name'))</title>

    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/icons/favicon-16x16.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#6366f1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="{{ config('platform.name') }}">
    <meta name="application-name" content="{{ config('platform.name') }}">

    @include('partials.seo-meta')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/ai-course.css') }}" rel="stylesheet">
    @stack('head')
    @stack('styles')
    @yield('styles')
</head>
<body class="ai-body">
    <nav class="ai-navbar navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
                <img src="{{ asset('assets/logos/patrick_logo.png') }}" alt="{{ config('platform.name') }} logo" width="36" height="36" style="border-radius: 8px;">
                <span>{{ config('platform.name') }}</span>
            </a>
            <button class="navbar-toggler border-0 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#aiNav">
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="aiNav">
                <ul class="navbar-nav me-auto ms-lg-3">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="fas fa-home me-1"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('courses.*') ? 'active' : '' }}" href="{{ route('courses.index') }}">
                            <i class="fas fa-graduation-cap me-1"></i> Courses
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('membership.*') ? 'active' : '' }}" href="{{ route('membership.index') }}" style="{{ !auth()->check() || auth()->user()->isFree() ? 'background: rgba(251,191,36,0.15); border-radius: 8px;' : '' }}">
                            <i class="fas fa-crown me-1" style="color: #fbbf24;"></i> Become a Member
                        </a>
                    </li>
                    @auth
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="fas fa-chart-line me-1"></i> My Learning
                        </a>
                    </li>
                    @endauth
                </ul>
                <ul class="navbar-nav align-items-lg-center gap-lg-2">
                    <li class="nav-item">
                        <a class="ai-btn ai-btn-outline ms-lg-2" href="{{ config('platform.parent_url') }}" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                            <i class="fas fa-external-link-alt"></i> {{ config('platform.parent_brand') }}
                        </a>
                    </li>
                    @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <img class="rounded-circle me-1" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=6366f1&color=fff" style="height: 28px; width: 28px;">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="fas fa-chart-line me-2"></i>My Learning</a></li>
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fas fa-user me-2"></i>Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger"><i class="fas fa-sign-out-alt me-2"></i>Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}"><i class="fas fa-sign-in-alt me-1"></i> Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="ai-btn ai-btn-primary ms-lg-2" href="{{ route('register') }}" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                            <i class="fas fa-user-plus"></i> Sign Up
                        </a>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    @foreach (['success', 'info', 'error'] as $type)
        @if(session($type))
            <div class="container mt-3">
                <div class="alert alert-{{ $type === 'error' ? 'danger' : $type }} alert-dismissible fade show">
                    {{ session($type) }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif
    @endforeach

    @yield('content')

    @hasSection('footer')
        @yield('footer')
    @else
    <footer class="ai-footer mt-auto">
        <div class="container text-center">
            <p class="mb-0">&copy; {{ date('Y') }} {{ config('platform.parent_brand') }} — AI Learning Platform</p>
            <p class="mb-0 mt-2">
                <a href="{{ config('platform.parent_url') }}" class="text-white-50 text-decoration-none">
                    <i class="fas fa-arrow-left me-1"></i> Back to {{ config('platform.parent_brand') }}
                </a>
            </p>
        </div>
    </footer>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
