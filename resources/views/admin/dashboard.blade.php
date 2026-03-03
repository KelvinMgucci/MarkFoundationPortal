@extends('layouts.admin')
@section('title', 'Dashboard')
@section('breadcrumb', 'Dashboard')

@section('content')
<div class="page-hd">
    <div>
        <h1>Dashboard</h1>
        <p>Welcome back, {{ auth('recruiter')->user()->name }}.</p>
    </div>
    <div style="display:flex;gap:.625rem;flex-wrap:wrap;">
        <a href="{{ route('admin.events.create') }}" class="btn btn-ghost btn-sm">+ Event</a>
        <a href="{{ route('admin.gallery.create') }}" class="btn btn-ghost btn-sm">+ Gallery</a>
        <a href="{{ route('admin.jobs.create') }}"   class="btn btn-green btn-sm">+ Job Posting</a>
    </div>
</div>

<div class="stats">
    <div class="stat-card stat-card--green">
        <p class="stat-card__label">Active Jobs</p>
        <p class="stat-card__value">{{ $stats['active_jobs'] }}</p>
        <p class="stat-card__sub">{{ $stats['total_jobs'] }} total postings</p>
    </div>
    <div class="stat-card">
        <p class="stat-card__label">Applications</p>
        <p class="stat-card__value">{{ $stats['total_applications'] }}</p>
        <p class="stat-card__sub">{{ $stats['new_applications'] }} new / unread</p>
    </div>
    <div class="stat-card stat-card--yellow">
        <p class="stat-card__label">Events</p>
        <p class="stat-card__value">{{ $stats['total_events'] }}</p>
        <p class="stat-card__sub">{{ $stats['upcoming_events'] }} upcoming</p>
    </div>
    <div class="stat-card">
        <p class="stat-card__label">Gallery Items</p>
        <p class="stat-card__value">{{ $stats['gallery_items'] }}</p>
        <p class="stat-card__sub">Photos &amp; videos</p>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;">

    {{-- Recent Events --}}
    <div class="card">
        <div style="display:flex;align-items:center;justify-content:space-between;padding:1.125rem 1.5rem;border-bottom:1px solid var(--border);">
            <h2 style="font-size:.95rem;">Recent Events</h2>
            <a href="{{ route('admin.events.index') }}" class="btn btn-ghost btn-sm">View all</a>
        </div>
        @if($recentEvents->isEmpty())
            <div class="empty" style="padding:2rem;">
                <p style="margin-bottom:.5rem;font-size:1.5rem;">📅</p>
                <p style="font-size:.875rem;">No events yet.</p>
                <a href="{{ route('admin.events.create') }}" class="btn btn-green btn-sm" style="margin-top:.75rem;">Create Event</a>
            </div>
        @else
            <div class="table-wrap">
                <table>
                    <thead><tr><th>Title</th><th>Date</th><th>Status</th></tr></thead>
                    <tbody>
                    @foreach($recentEvents as $event)
                    <tr>
                        <td style="font-weight:600;">{{ Str::limit($event->title, 32) }}</td>
                        <td style="font-size:.8rem;white-space:nowrap;">{{ $event->start_date->format('d M Y') }}</td>
                        <td>
                            <span class="badge {{ $event->isUpcoming() ? 'badge-upcoming' : 'badge-past' }}">
                                {{ $event->isUpcoming() ? 'Upcoming' : 'Past' }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- Recent Gallery --}}
    <div class="card">
        <div style="display:flex;align-items:center;justify-content:space-between;padding:1.125rem 1.5rem;border-bottom:1px solid var(--border);">
            <h2 style="font-size:.95rem;">Recent Gallery</h2>
            <a href="{{ route('admin.gallery.index') }}" class="btn btn-ghost btn-sm">View all</a>
        </div>
        @if($recentGallery->isEmpty())
            <div class="empty" style="padding:2rem;">
                <p style="margin-bottom:.5rem;font-size:1.5rem;">🖼</p>
                <p style="font-size:.875rem;">No gallery items yet.</p>
                <a href="{{ route('admin.gallery.create') }}" class="btn btn-green btn-sm" style="margin-top:.75rem;">Add Item</a>
            </div>
        @else
            <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:.625rem;padding:1.125rem;">
                @foreach($recentGallery as $item)
                <div style="aspect-ratio:1;border-radius:var(--radius);overflow:hidden;background:var(--green-lt);position:relative;">
                    @if($item->isPhoto() && $item->file_path)
                        <img src="{{ Storage::url($item->file_path) }}" style="width:100%;height:100%;object-fit:cover;">
                    @else
                        <div style="width:100%;height:100%;background:var(--black);display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.5rem;">▶</div>
                    @endif
                    @if(!$item->is_visible)
                        <div style="position:absolute;inset:0;background:rgba(0,0,0,.5);display:flex;align-items:center;justify-content:center;color:rgba(255,255,255,.7);font-size:.7rem;font-weight:700;">HIDDEN</div>
                    @endif
                </div>
                @endforeach
            </div>
        @endif
    </div>

</div>
@endsection
