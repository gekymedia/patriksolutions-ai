@props([
    'icon' => null,
    'title' => null,
    'subtitle' => null,
])

<section class="ai-auth-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7 col-sm-10">
                <div class="ai-auth-card">
                    @if($icon)
                        <div class="ai-auth-icon"><i class="fas fa-{{ $icon }}"></i></div>
                    @endif
                    @if($title)
                        <h1 class="ai-auth-title">{{ $title }}</h1>
                    @endif
                    @if($subtitle)
                        <p class="ai-auth-subtitle">{{ $subtitle }}</p>
                    @endif
                    {{ $slot }}
                </div>
                @isset($footer)
                    <p class="text-center mt-3 mb-0">{!! $footer !!}</p>
                @endisset
            </div>
        </div>
    </div>
</section>
