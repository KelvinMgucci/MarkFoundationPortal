@extends('layouts.public')
@section('title', $event->title . ' - Mark Foundation')

@push('styles')
<style>
.event-hero {
    background:linear-gradient(135deg,var(--green-dk),var(--green));
    padding:3rem 0;margin-bottom:2.5rem;position:relative;overflow:hidden;
}
.event-hero::before { content:'';position:absolute;inset:0;background:radial-gradient(ellipse 40% 80% at 80% 50%,rgba(240,192,48,.2) 0%,transparent 60%); }
.event-hero::after { content:'';position:absolute;bottom:-1px;left:0;right:0;height:50px;background:var(--cream);clip-path:ellipse(55% 100% at 50% 100%); }
.event-hero__inner { position:relative;z-index:1; }
.event-hero h1 { font-size:clamp(1.75rem,4vw,2.75rem);color:#fff;margin-bottom:1rem; }
.event-hero__meta { display:flex;gap:.75rem;flex-wrap:wrap; }
.event-hero__meta .pill { background:rgba(255,255,255,.15);border-color:rgba(255,255,255,.3);color:#fff; }

.event-layout { display:grid;grid-template-columns:1fr 320px;gap:2rem;align-items:start; }
@media(max-width:900px){.event-layout{grid-template-columns:1fr;}}

.prose { font-size:.95rem;color:var(--ink-2);line-height:1.85;white-space:pre-line; }
.section-block { background:var(--white);border:1px solid var(--border);border-radius:var(--radius-lg);padding:1.75rem;margin-bottom:1.5rem; }
.section-block h2 { font-size:1.1rem;margin-bottom:1rem;padding-bottom:.75rem;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:.5rem;color:var(--ink); }

/* Media grid */
.media-grid { display:grid;grid-template-columns:repeat(3,1fr);gap:.875rem; }
@media(max-width:600px){.media-grid{grid-template-columns:repeat(2,1fr);}}
.media-item {
    aspect-ratio:1;border-radius:var(--radius);overflow:hidden;cursor:pointer;
    background:var(--green-lt);position:relative;
}
.media-item img { width:100%;height:100%;object-fit:cover;transition:transform .3s; }
.media-item:hover img { transform:scale(1.06); }
.media-item .overlay { position:absolute;inset:0;background:rgba(0,0,0,.35);opacity:0;transition:opacity .3s;display:flex;align-items:center;justify-content:center;font-size:1.5rem;color:#fff; }
.media-item:hover .overlay { opacity:1; }
.media-item--video { background:#111; }
.media-item--video .play { position:absolute;inset:0;display:flex;align-items:center;justify-content:center;font-size:2.5rem;color:rgba(255,255,255,.8); }

/* Sidebar */
.sidebar-sticky { position:sticky;top:84px; }
.info-card { background:var(--white);border:1px solid var(--border);border-radius:var(--radius-lg);padding:1.5rem;margin-bottom:1.25rem; }
.info-card h3 { font-size:.95rem;margin-bottom:1rem;padding-bottom:.75rem;border-bottom:1px solid var(--border);color:var(--ink); }
.info-row { display:flex;gap:.75rem;margin-bottom:.875rem;font-size:.875rem; }
.info-row__icon { font-size:1.1rem;flex-shrink:0;margin-top:.05rem; }
.info-row__label { font-size:.72rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:var(--ink-3);margin-bottom:.15rem; }
.info-row__val { font-weight:500;color:var(--ink); }

/* Lightbox */
.lightbox { position:fixed;inset:0;background:rgba(0,0,0,.92);z-index:9999;display:none;align-items:center;justify-content:center;padding:1.5rem; }
.lightbox.open { display:flex; }
.lightbox__close { position:absolute;top:1rem;right:1.25rem;background:none;border:none;color:#fff;font-size:2rem;cursor:pointer; }
.lightbox__media img { max-width:90vw;max-height:80vh;border-radius:8px;display:block; }
.lightbox__media iframe { width:80vw;max-width:900px;height:50vw;max-height:500px;border-radius:8px; }
.lightbox__media video { max-width:90vw;max-height:80vh;border-radius:8px; }
</style>
@endpush

@section('content')

<div class="event-hero">
    <div class="wrap event-hero__inner">
        <a href="{{ route('events.index') }}" style="color:rgba(255,255,255,.6);font-size:.82rem;text-decoration:none;display:inline-block;margin-bottom:1rem;">← All Events</a>
        <h1>{{ $event->title }}</h1>
        <div class="event-hero__meta">
            <span class="pill">🗓 {{ $event->start_date->format('d M Y') }}</span>
            @if($event->location)<span class="pill">📍 {{ $event->location }}</span>@endif
            @if($event->isUpcoming())<span class="pill" style="background:rgba(240,192,48,.3);border-color:var(--yellow);color:var(--yellow);">Upcoming</span>
            @else<span class="pill" style="background:rgba(0,0,0,.3);">Past Event</span>@endif
        </div>
    </div>
</div>

<div class="wrap page-main" style="padding-top:0;">
    <div class="event-layout">
        {{-- LEFT --}}
        <div>
            @if($event->cover_image_path)
            <div style="border-radius:var(--radius-lg);overflow:hidden;margin-bottom:1.5rem;max-height:420px;">
                <img src="{{ Storage::url($event->cover_image_path) }}" alt="{{ $event->title }}" style="width:100%;height:100%;object-fit:cover;">
            </div>
            @endif

            <div class="section-block">
                <h2>📋 About This Event</h2>
                <div class="prose">{{ $event->description }}</div>
            </div>

            {{-- Photos --}}
            @if($event->photos->count() > 0)
            <div class="section-block">
                <h2>📷 Photos ({{ $event->photos->count() }})</h2>
                <div class="media-grid">
                    @foreach($event->photos as $photo)
                    <div class="media-item" onclick="openLb('photo','{{ Storage::url($photo->file_path) }}','{{ addslashes($photo->caption ?? '') }}')">
                        <img src="{{ Storage::url($photo->file_path) }}" alt="{{ $photo->caption }}" loading="lazy">
                        <div class="overlay">🔍</div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Videos --}}
            @if($event->videos->count() > 0)
            <div class="section-block">
                <h2>🎥 Videos ({{ $event->videos->count() }})</h2>
                <div class="media-grid">
                    @foreach($event->videos as $video)
                    <div class="media-item media-item--video" onclick="openLb('video','{{ $video->embedUrl() ?? ($video->file_path ? Storage::url($video->file_path) : '') }}','{{ addslashes($video->caption ?? '') }}')">
                        @if($video->file_path)
                            <video src="{{ Storage::url($video->file_path) }}" style="width:100%;height:100%;object-fit:cover;" muted></video>
                        @endif
                        <div class="play">▶</div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        {{-- SIDEBAR --}}
        <div class="sidebar-sticky">
            <div class="info-card">
                <h3>Event Details</h3>
                <div class="info-row">
                    <span class="info-row__icon">🗓</span>
                    <div>
                        <div class="info-row__label">Date</div>
                        <div class="info-row__val">{{ $event->start_date->format('l, d M Y') }}</div>
                        @if($event->end_date)
                        <div style="font-size:.8rem;color:var(--ink-3);">Until {{ $event->end_date->format('d M Y') }}</div>
                        @endif
                    </div>
                </div>
                @if($event->location)
                <div class="info-row">
                    <span class="info-row__icon">📍</span>
                    <div>
                        <div class="info-row__label">Location</div>
                        <div class="info-row__val">{{ $event->location }}</div>
                    </div>
                </div>
                @endif
                <div class="info-row">
                    <span class="info-row__icon">📸</span>
                    <div>
                        <div class="info-row__label">Media</div>
                        <div class="info-row__val">{{ $event->photos->count() }} photos · {{ $event->videos->count() }} videos</div>
                    </div>
                </div>
            </div>

            @if($event->rsvp_link && $event->isUpcoming())
            <a href="{{ $event->rsvp_link }}" target="_blank" class="btn btn-yellow" style="width:100%;justify-content:center;font-size:.95rem;padding:.875rem;">
                Register / RSVP →
            </a>
            @endif

            <a href="{{ route('events.index') }}" class="btn btn-outline" style="width:100%;justify-content:center;margin-top:.75rem;">
                ← Back to Events
            </a>
        </div>
    </div>
</div>

<div class="lightbox" id="lightbox" onclick="closeLb(event)">
    <button class="lightbox__close">✕</button>
    <div class="lightbox__media" id="lbMedia"></div>
</div>

<script>
function openLb(type, src, caption) {
    const lb = document.getElementById('lightbox');
    const m  = document.getElementById('lbMedia');
    if (!src) return;
    if (type === 'photo') {
        m.innerHTML = `<img src="${src}" alt="${caption}">`;
    } else if (src.includes('youtube.com/embed') || src.includes('player.vimeo')) {
        m.innerHTML = `<iframe src="${src}" frameborder="0" allowfullscreen allow="autoplay"></iframe>`;
    } else {
        m.innerHTML = `<video src="${src}" controls autoplay></video>`;
    }
    lb.classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeLb(e) {
    if (!e || e.target.classList.contains('lightbox') || e.target.classList.contains('lightbox__close')) {
        document.getElementById('lightbox').classList.remove('open');
        document.getElementById('lbMedia').innerHTML = '';
        document.body.style.overflow = '';
    }
}
document.addEventListener('keydown', e => { if(e.key==='Escape') closeLb(); });
</script>
@endsection
