@extends('layouts.public')

@section('title', 'Open Positions')

@push('styles')
<style>
.page-banner {
    background: var(--ink);
    margin: -4rem -1.5rem 3rem;
    padding: 3.5rem 1.5rem;
    position: relative;
    overflow: hidden;
}
.page-banner::after {
    content: '';
    position: absolute;
    bottom: -1px; left: 0; right: 0;
    height: 60px;
    background: var(--cream);
    clip-path: ellipse(55% 100% at 50% 100%);
}
.page-banner::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(ellipse 50% 100% at 90% 50%, rgba(232,160,32,.15) 0%, transparent 60%);
}
.page-banner__inner { position: relative; z-index: 1; }
.page-banner h1 { font-size: clamp(1.75rem, 3vw, 2.75rem); color: var(--white); }
.page-banner p  { color: rgba(255,255,255,.55); margin-top: .5rem; font-size: .95rem; }

.filter-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.5rem;
    gap: 1rem;
    flex-wrap: wrap;
}
.filter-row__count { font-size: .875rem; color: var(--ink-3); }

.job-card {
    display: grid;
    grid-template-columns: 1fr auto;
    gap: 1.25rem;
    align-items: center;
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    padding: 1.5rem;
    margin-bottom: 1rem;
    transition: transform .2s, box-shadow .2s, border-color .2s;
}
.job-card:hover { border-color: var(--amber); box-shadow: 0 4px 24px rgba(0,0,0,.07); transform: translateY(-2px); }
.job-card__title { font-size: 1.05rem; font-weight: 600; color: var(--ink); margin-bottom: .5rem; }
.job-card__meta  { display: flex; gap: .65rem; flex-wrap: wrap; margin-bottom: .875rem; }
.job-card__excerpt { font-size: .875rem; color: var(--ink-3); line-height: 1.7; max-width: 640px; }
.job-card__right { text-align: right; display: flex; flex-direction: column; gap: .75rem; align-items: flex-end; }

.empty-state {
    text-align: center;
    padding: 5rem 2rem;
    background: var(--white);
    border: 1px dashed var(--border-dk);
    border-radius: var(--radius-lg);
}
.empty-state h3 { font-size: 1.2rem; margin-bottom: .5rem; }
.empty-state p  { color: var(--ink-3); font-size: .9rem; }
</style>
@endpush

@section('content')

<div class="page-banner">
    <div class="page-banner__inner">
        <h1>Open Positions</h1>
        <p>Find a role where you can do the best work of your career.</p>
    </div>
</div>

<div class="filter-row">
    <p class="filter-row__count">
        @if($jobs->isEmpty())
            No open positions at this time
        @else
            Showing <strong>{{ $jobs->count() }}</strong> open {{ Str::plural('position', $jobs->count()) }}
        @endif
    </p>
</div>

@forelse($jobs as $job)
<div class="job-card">
    <div>
        <p class="job-card__title">{{ $job->title }}</p>
        <div class="job-card__meta">
            <span class="pill">📍 {{ $job->location }}</span>
            <span class="pill pill-amber">{{ $job->type }}</span>
        </div>
        <p class="job-card__excerpt">{{ $job->excerpt(180) }}</p>
    </div>
    <div class="job-card__right">
        <a href="{{ route('jobs.show', $job) }}" class="btn btn-amber btn-sm">
            Apply Now
        </a>
        <a href="{{ route('jobs.show', $job) }}" style="font-size:.8rem; color:var(--ink-3); text-decoration:none;">
            Read more →
        </a>
    </div>
</div>
@empty
<div class="empty-state">
    <p style="font-size:2rem; margin-bottom:1rem;">🔍</p>
    <h3>No open positions right now</h3>
    <p>We don't have any active roles at the moment.<br>Please check back soon — we're always growing.</p>
</div>
@endforelse

@endsection
