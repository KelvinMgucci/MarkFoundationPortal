@extends('layouts.public')
@section('title', 'Events - Mark Foundation')

@push('styles')
<style>
.page-banner { background:linear-gradient(135deg,var(--green-dk),var(--green));padding:3.5rem 0 4rem;margin-bottom:3rem;position:relative;overflow:hidden; }
.page-banner::after { content:'';position:absolute;bottom:-1px;left:0;right:0;height:60px;background:var(--cream);clip-path:ellipse(55% 100% at 50% 100%); }
.page-banner::before { content:'';position:absolute;inset:0;background:radial-gradient(ellipse 50% 100% at 90% 50%,rgba(240,192,48,.2) 0%,transparent 60%); }
.page-banner__inner { position:relative;z-index:1;text-align:center; }
.page-banner h1 { font-size:clamp(1.75rem,4vw,3rem);color:var(--white);margin-bottom:.5rem; }
.page-banner p  { color:rgba(255,255,255,.7);font-size:1rem; }

.events-section-title { font-size:1.35rem;font-weight:700;color:var(--green-dk);margin-bottom:1.5rem;padding-bottom:.75rem;border-bottom:2px solid var(--yellow);display:flex;align-items:center;gap:.5rem; }

.event-card {
    display:grid;grid-template-columns:auto 1fr auto;gap:1.5rem;align-items:center;
    background:var(--white);border:1px solid var(--border);border-radius:var(--radius-lg);
    padding:1.5rem;margin-bottom:1rem;text-decoration:none;color:inherit;
    transition:all .2s;
}
.event-card:hover { border-color:var(--green);box-shadow:var(--shadow-lg);transform:translateY(-2px); }
.event-card__date {
    background:var(--green);color:#fff;border-radius:var(--radius);
    width:64px;height:64px;display:flex;flex-direction:column;align-items:center;justify-content:center;flex-shrink:0;
}
.event-card__date .day   { font-family:var(--font-head);font-size:1.5rem;font-weight:800;line-height:1; }
.event-card__date .month { font-size:.7rem;letter-spacing:.05em;text-transform:uppercase;opacity:.85; }
.event-card__body h3 { font-size:1.05rem;font-weight:600;margin-bottom:.4rem; }
.event-card__body p  { font-size:.875rem;color:var(--ink-3);line-height:1.6; }
.event-card__meta { display:flex;gap:.625rem;flex-wrap:wrap;margin-top:.5rem; }
.event-card__cta { font-size:.85rem;font-weight:600;color:var(--green);white-space:nowrap;display:flex;align-items:center;gap:.25rem; }

.past-grid { display:grid;grid-template-columns:repeat(3,1fr);gap:1.25rem; }
@media(max-width:900px){.past-grid{grid-template-columns:1fr 1fr;}}
@media(max-width:600px){.past-grid,.event-card{grid-template-columns:1fr;} .event-card__date{display:none;} .event-card__cta{display:none;}}

.past-card { background:var(--white);border:1px solid var(--border);border-radius:var(--radius-lg);overflow:hidden;text-decoration:none;color:inherit;display:block;transition:all .2s; }
.past-card:hover { box-shadow:var(--shadow-lg);transform:translateY(-2px); }
.past-card__img { height:160px;background:linear-gradient(135deg,var(--ink),var(--ink-2));display:flex;align-items:center;justify-content:center;font-size:2.5rem;position:relative;overflow:hidden; }
.past-card__img img { width:100%;height:100%;object-fit:cover;position:absolute;inset:0; }
.past-card__past-badge { position:absolute;top:.625rem;right:.625rem;background:rgba(0,0,0,.6);color:rgba(255,255,255,.7);font-size:.7rem;padding:.2rem .5rem;border-radius:4px; }
.past-card__body { padding:1.25rem; }
.past-card__body h3 { font-size:.95rem;font-weight:600;margin-bottom:.4rem; }
.past-card__body .meta { font-size:.78rem;color:var(--ink-3); }

.empty-state { text-align:center;padding:3rem;background:var(--white);border:1px dashed var(--border-dk);border-radius:var(--radius-lg);color:var(--ink-3); }
</style>
@endpush

@section('content')
<div class="page-banner">
    <div class="wrap page-banner__inner">
        <h1>Events</h1>
        <p>Stay connected with what's happening at Mark Foundation.</p>
    </div>
</div>

<div class="wrap page-main">

    {{-- Upcoming --}}
    <div style="margin-bottom:3rem;">
        <h2 class="events-section-title">📅 Upcoming Events</h2>
        @forelse($upcoming as $event)
        <a href="{{ route('events.show', $event) }}" class="event-card">
            <div class="event-card__date">
                <span class="day">{{ $event->start_date->format('d') }}</span>
                <span class="month">{{ $event->start_date->format('M Y') }}</span>
            </div>
            <div class="event-card__body">
                <h3>{{ $event->title }}</h3>
                <p>{{ Str::limit($event->description, 120) }}</p>
                <div class="event-card__meta">
                    @if($event->location)<span class="pill">📍 {{ $event->location }}</span>@endif
                    @if($event->end_date)<span class="pill">Until {{ $event->end_date->format('d M') }}</span>@endif
                    @if($event->rsvp_link)<span class="pill" style="background:var(--yellow-lt);color:var(--ink);">RSVP Available</span>@endif
                </div>
            </div>
            <span class="event-card__cta">View →</span>
        </a>
        @empty
        <div class="empty-state">
            <p style="font-size:2rem;margin-bottom:.5rem;">📭</p>
            <p>No upcoming events right now. Check back soon!</p>
        </div>
        @endforelse
    </div>

    {{-- Past --}}
    @if($past->count() > 0)
    <div>
        <h2 class="events-section-title">🕐 Past Events</h2>
        <div class="past-grid">
            @foreach($past as $event)
            <a href="{{ route('events.show', $event) }}" class="past-card">
                <div class="past-card__img">
                    @if($event->cover_image_path)
                        <img src="{{ Storage::url($event->cover_image_path) }}" alt="{{ $event->title }}">
                    @else
                        📸
                    @endif
                    <span class="past-card__past-badge">Past Event</span>
                </div>
                <div class="past-card__body">
                    <h3>{{ $event->title }}</h3>
                    <p class="meta">🗓 {{ $event->start_date->format('d M Y') }}@if($event->location) · 📍 {{ $event->location }}@endif</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection
