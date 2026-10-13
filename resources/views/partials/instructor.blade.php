@php
    $inst = config('platform.instructor');
    $instPhoto = public_path($inst['photo']);
    $instPhotoUrl = is_file($instPhoto)
        ? asset($inst['photo'])
        : 'https://ui-avatars.com/api/?name=' . urlencode($inst['name']) . '&size=256&background=6366f1&color=fff&bold=true';
@endphp
<div class="ai-card p-4 p-lg-5">
    <div class="row align-items-center g-4">
        <div class="col-md-auto text-center">
            <img src="{{ $instPhotoUrl }}" alt="{{ $inst['name'] }} — {{ $inst['role'] }}"
                 width="140" height="140"
                 style="width:140px;height:140px;object-fit:cover;border-radius:20px;box-shadow:var(--ai-glow);">
        </div>
        <div class="col-md">
            <div class="ai-badge mb-2"><i class="fas fa-chalkboard-teacher"></i> Your instructor</div>
            <h3 class="fw-bold mb-1">{{ $inst['name'] }}</h3>
            <p class="mb-2" style="color: var(--ai-primary); font-weight: 600;">{{ $inst['role'] }}</p>
            <p class="small text-muted mb-2"><i class="fas fa-certificate me-1"></i> {{ $inst['credentials'] }}</p>
            <p class="mb-0 text-muted">{{ $inst['short_bio'] }}</p>
        </div>
    </div>
</div>
