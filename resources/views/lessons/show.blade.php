@extends('layouts.platform')
@section('title', $lesson->title . ' — ' . $course->name)
@section('meta_robots', 'noindex, nofollow')

@section('footer')@endsection

@section('content')
@php
    // CTA destinations differ by course tier and whether the viewer is signed in.
    $signupUrl = route('register', ['redirect' => route('courses.show', $course)]);
    $unlockUrl = $course->isFreePlan() ? $signupUrl : route('membership.index');
@endphp
<style>
.lesson-md h1{font-size:1.6rem;margin:1.5rem 0 .6rem;font-weight:700}
.lesson-md h2{font-size:1.3rem;margin:1.4rem 0 .5rem;font-weight:700}
.lesson-md h3{font-size:1.1rem;margin:1.1rem 0 .4rem;font-weight:700}
.lesson-md p{margin:0 0 .9rem;line-height:1.75}
.lesson-md ul,.lesson-md ol{margin:0 0 1rem 1.3rem;line-height:1.75}
.lesson-md li{margin-bottom:.3rem}
.lesson-md code{background:rgba(0,0,0,.06);padding:.1rem .35rem;border-radius:4px;font-size:.9em}
.lesson-md pre{background:#0f172a;color:#e2e8f0;padding:1rem;border-radius:10px;overflow:auto;margin:0 0 1rem}
.lesson-md pre code{background:none;padding:0;color:inherit}
.lesson-md table{width:100%;border-collapse:collapse;margin:0 0 1.1rem;font-size:.95em}
.lesson-md th,.lesson-md td{border:1px solid rgba(0,0,0,.12);padding:.5rem .7rem;text-align:left;vertical-align:top}
.lesson-md th{background:rgba(0,0,0,.03)}
.lesson-md blockquote{border-left:4px solid #c8a046;margin:0 0 1rem;padding:.5rem 0 .5rem 1rem;background:rgba(200,160,70,.07)}
.lesson-md hr{border:none;border-top:1px solid rgba(0,0,0,.1);margin:1.6rem 0}
.lesson-md a{color:#1E7A46;text-decoration:underline}
</style>
<div class="ai-lesson-layout">
    <aside class="ai-lesson-sidebar">
        <div class="p-3 border-bottom" style="border-color: rgba(255,255,255,0.08) !important;">
            <a href="{{ route('courses.show', $course) }}" class="text-white text-decoration-none small"><i class="fas fa-arrow-left"></i> Back</a>
            <h6 class="text-white fw-bold mt-2 mb-0">{{ $course->name }}</h6>
        </div>
        @foreach($lessons as $i => $l)
            @php $locked = ! $l->is_preview && ! $hasFullAccess; @endphp
            @if($locked)
                <a href="{{ $unlockUrl }}" class="ai-lesson-item" title="{{ $course->isFreePlan() ? 'Sign up free to unlock this lesson' : 'Upgrade to unlock this lesson' }}">
                    <span class="ai-lesson-check"><i class="fas fa-lock"></i></span>
                    <span>{{ $i + 1 }}. {{ Str::limit($l->title, 28) }}</span>
                </a>
            @else
                <a href="{{ route('lessons.show', [$course, $l]) }}" class="ai-lesson-item {{ $l->id === $lesson->id ? 'active' : '' }} {{ in_array($l->id, $completedLessonIds) ? 'completed' : '' }}">
                    <span class="ai-lesson-check">@if(in_array($l->id, $completedLessonIds))<i class="fas fa-check-circle"></i>@elseif($l->is_preview && ! $hasFullAccess)<i class="fas fa-eye"></i>@else<i class="far fa-circle"></i>@endif</span>
                    <span>{{ $i + 1 }}. {{ Str::limit($l->title, 28) }}</span>
                </a>
            @endif
        @endforeach
    </aside>
    <main class="ai-lesson-main">
        <h1 class="fw-bold mb-3">{{ $lesson->title }}</h1>
        <p class="text-muted mb-4">{{ $lesson->description }}</p>
        @unless($hasFullAccess)
            @if($course->isFreePlan())
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4 p-3"
                     style="background:rgba(34,197,94,0.1);border:1px solid rgba(34,197,94,0.3);color:#166534;border-radius:12px;">
                    <span><i class="fas fa-gift me-2"></i> This is a <strong>free course</strong>. Create your free account to unlock all {{ $lessons->count() }} lessons and track your progress.</span>
                    <a href="{{ $signupUrl }}" class="ai-btn ai-btn-primary"><i class="fas fa-user-plus"></i> Sign up free</a>
                </div>
            @else
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4 p-3"
                     style="background:#fff3cd;border:1px solid #ffe69c;color:#664d03;border-radius:12px;">
                    <span><i class="fas fa-unlock-alt me-2"></i> You're viewing a <strong>free preview</strong>. Upgrade to unlock the full course, the AI tutor, and progress tracking.</span>
                    <a href="{{ route('membership.index') }}" class="ai-btn ai-btn-primary">See plans</a>
                </div>
            @endif
        @endunless
        @if($lesson->video_url)
            <div class="ai-video-wrapper">
                @if(str_contains($lesson->video_url, 'youtube') || str_contains($lesson->video_url, 'youtu.be'))
                    @php preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]+)/', $lesson->video_url, $m); @endphp
                    <iframe src="https://www.youtube.com/embed/{{ $m[1] ?? '' }}" allowfullscreen></iframe>
                @else
                    <video controls src="{{ $lesson->video_url }}"></video>
                @endif
            </div>
        @endif
        @if($contentHtml)
            <div class="ai-content-body lesson-md">{!! $contentHtml !!}</div>
        @endif
        <div class="d-flex justify-content-between mt-5 pt-4 border-top">
            @if($prevLesson)<a href="{{ route('lessons.show', [$course, $prevLesson]) }}" class="ai-btn ai-btn-dark"><i class="fas fa-arrow-left"></i> Previous</a>@else<span></span>@endif
            <div class="d-flex gap-2">
                @if($hasFullAccess)
                    @if(!$isCompleted)
                        <form action="{{ route('lessons.complete', [$course, $lesson]) }}" method="POST">@csrf
                            <button type="submit" class="ai-btn ai-btn-primary"><i class="fas fa-check"></i> Complete</button>
                        </form>
                    @else
                        <span class="badge bg-success fs-6 py-2 px-3">Completed</span>
                    @endif
                @elseif($course->isFreePlan())
                    <a href="{{ $signupUrl }}" class="ai-btn ai-btn-primary"><i class="fas fa-user-plus"></i> Sign up free to continue</a>
                @else
                    <a href="{{ route('membership.index') }}" class="ai-btn ai-btn-primary"><i class="fas fa-unlock"></i> Upgrade to continue</a>
                @endif
                @if($nextLesson && ($hasFullAccess || $nextLesson->is_preview))<a href="{{ route('lessons.show', [$course, $nextLesson]) }}" class="ai-btn ai-btn-dark">Next <i class="fas fa-arrow-right"></i></a>@endif
            </div>
        </div>
    </main>
    <aside class="ai-tutor-panel">
        <div class="ai-tutor-header"><i class="fas fa-robot me-2"></i> AI Tutor</div>
        @if($hasFullAccess)
            <div class="ai-chat-messages" id="chatMessages">
                <div class="ai-chat-bubble assistant">Hi! Ask me anything about <strong>{{ $lesson->title }}</strong>.</div>
            </div>
            <div class="ai-chat-input-area">
                <form id="tutorForm" class="d-flex gap-2">
                    @csrf
                    <input type="text" id="tutorInput" class="form-control form-control-sm" placeholder="Ask a question..." maxlength="1000">
                    <button type="submit" class="ai-btn ai-btn-primary" style="padding: 0.375rem 0.875rem;" id="tutorSendBtn"><i class="fas fa-paper-plane"></i></button>
                </form>
                <div class="small text-muted mt-2" id="tutorStatus"></div>
            </div>
        @else
            <div class="p-4 text-center">
                <p class="text-muted small mb-3"><i class="fas fa-lock me-1"></i> The AI tutor is included with AI Member &amp; AI Pro.</p>
                <a href="{{ route('membership.index') }}" class="ai-btn ai-btn-primary w-100">See plans</a>
            </div>
        @endif
    </aside>
</div>
@endsection

@push('scripts')
@if($hasFullAccess)
<script>
(function () {
    const form = document.getElementById('tutorForm');
    const input = document.getElementById('tutorInput');
    const messages = document.getElementById('chatMessages');
    const sendBtn = document.getElementById('tutorSendBtn');
    const status = document.getElementById('tutorStatus');
    const chatUrl = @json(route('tutor.chat', [$course, $lesson]));
    const csrf = document.querySelector('meta[name="csrf-token"]').content;
    let history = [];

    function appendBubble(role, text) {
        const div = document.createElement('div');
        div.className = 'ai-chat-bubble ' + role;
        div.textContent = text;
        messages.appendChild(div);
        messages.scrollTop = messages.scrollHeight;
    }

    form.addEventListener('submit', async function (e) {
        e.preventDefault();
        const message = input.value.trim();
        if (!message) return;
        appendBubble('user', message);
        history.push({ role: 'user', content: message });
        input.value = '';
        sendBtn.disabled = true;
        status.textContent = 'Thinking...';
        try {
            const res = await fetch(chatUrl, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                body: JSON.stringify({ message, history }),
            });
            const data = await res.json();
            if (data.success) {
                appendBubble('assistant', data.reply);
                history.push({ role: 'assistant', content: data.reply });
                status.textContent = data.remaining !== undefined ? data.remaining + ' questions left today' : '';
            } else {
                appendBubble('assistant', data.message || 'Error. Try again.');
                status.textContent = '';
            }
        } catch {
            appendBubble('assistant', 'Network error.');
            status.textContent = '';
        }
        sendBtn.disabled = false;
    });
})();
</script>
@endif
@endpush
