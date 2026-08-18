@extends('layouts.platform')
@section('title', $lesson->title)

@section('footer')@endsection

@section('content')
<div class="ai-lesson-layout">
    <aside class="ai-lesson-sidebar">
        <div class="p-3 border-bottom" style="border-color: rgba(255,255,255,0.08) !important;">
            <a href="{{ route('courses.show', $course) }}" class="text-white text-decoration-none small"><i class="fas fa-arrow-left"></i> Back</a>
            <h6 class="text-white fw-bold mt-2 mb-0">{{ $course->name }}</h6>
        </div>
        @foreach($lessons as $i => $l)
            <a href="{{ route('lessons.show', [$course, $l]) }}" class="ai-lesson-item {{ $l->id === $lesson->id ? 'active' : '' }} {{ in_array($l->id, $completedLessonIds) ? 'completed' : '' }}">
                <span class="ai-lesson-check">@if(in_array($l->id, $completedLessonIds))<i class="fas fa-check-circle"></i>@else<i class="far fa-circle"></i>@endif</span>
                <span>{{ $i + 1 }}. {{ Str::limit($l->title, 30) }}</span>
            </a>
        @endforeach
    </aside>
    <main class="ai-lesson-main">
        <h1 class="fw-bold mb-3">{{ $lesson->title }}</h1>
        <p class="text-muted mb-4">{{ $lesson->description }}</p>
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
        @if($lesson->content)
            <div class="ai-content-body">{!! nl2br(e($lesson->content)) !!}</div>
        @endif
        <div class="d-flex justify-content-between mt-5 pt-4 border-top">
            @if($prevLesson)<a href="{{ route('lessons.show', [$course, $prevLesson]) }}" class="ai-btn ai-btn-dark"><i class="fas fa-arrow-left"></i> Previous</a>@else<span></span>@endif
            <div class="d-flex gap-2">
                @if(!$isCompleted)
                    <form action="{{ route('lessons.complete', [$course, $lesson]) }}" method="POST">@csrf
                        <button type="submit" class="ai-btn ai-btn-primary"><i class="fas fa-check"></i> Complete</button>
                    </form>
                @else
                    <span class="badge bg-success fs-6 py-2 px-3">Completed</span>
                @endif
                @if($nextLesson)<a href="{{ route('lessons.show', [$course, $nextLesson]) }}" class="ai-btn ai-btn-dark">Next <i class="fas fa-arrow-right"></i></a>@endif
            </div>
        </div>
    </main>
    <aside class="ai-tutor-panel">
        <div class="ai-tutor-header"><i class="fas fa-robot me-2"></i> AI Tutor</div>
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
    </aside>
</div>
@endsection

@push('scripts')
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
@endpush
