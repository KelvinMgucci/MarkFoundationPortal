@extends('layouts.admin')
@section('title', 'Events')
@section('breadcrumb', 'Events')

@section('content')
<div class="page-hd">
    <div><h1>Events</h1><p>Manage community events and their photos/videos.</p></div>
    <a href="{{ route('admin.events.create') }}" class="btn btn-green">
        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
        New Event
    </a>
</div>

<div class="card">
    @if($events->isEmpty())
        <div class="empty">
            <div class="empty__icon">📅</div>
            <h3>No events yet</h3>
            <p>Create your first event to share with the community.</p>
            <a href="{{ route('admin.events.create') }}" class="btn btn-green">Create Event</a>
        </div>
    @else
        <div class="table-wrap">
            <table>
                <thead>
                    <tr><th>Event</th><th>Date</th><th>Location</th><th>Media</th><th>Status</th><th>Actions</th></tr>
                </thead>
                <tbody>
                @foreach($events as $event)
                <tr>
                    <td>
                        <span style="font-weight:600;color:var(--ink);">{{ $event->title }}</span>
                        @if($event->rsvp_link)
                            <span class="badge badge-upcoming" style="margin-left:.4rem;font-size:.65rem;">RSVP</span>
                        @endif
                    </td>
                    <td style="white-space:nowrap;font-size:.85rem;">
                        {{ $event->start_date->format('d M Y') }}
                        <div style="font-size:.75rem;color:var(--ink-3);margin-top:.1rem;">
                            {{ $event->isUpcoming() ? '🟢 Upcoming' : '⚫ Past' }}
                        </div>
                    </td>
                    <td style="font-size:.85rem;">{{ $event->location ?? '—' }}</td>
                    <td>
                        @if($event->media_count > 0)
                            <a href="{{ route('admin.events.edit', $event) }}" style="color:var(--green);font-weight:600;text-decoration:none;">
                                {{ $event->media_count }} file(s)
                            </a>
                        @else
                            <span style="color:var(--ink-3);">None</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge {{ $event->is_published ? 'badge-published' : 'badge-draft' }}">
                            {{ $event->is_published ? 'Published' : 'Draft' }}
                        </span>
                    </td>
                    <td>
                        <div class="actions">
                            <form method="POST" action="{{ route('admin.events.toggle', $event) }}">@csrf
                                <button class="btn btn-ghost btn-sm">{{ $event->is_published ? 'Unpublish' : 'Publish' }}</button>
                            </form>
                            <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-ghost btn-sm">Edit</a>
                            <a href="{{ route('events.show', $event) }}" class="btn btn-ghost btn-sm" target="_blank">View ↗</a>
                            <form method="POST" action="{{ route('admin.events.destroy', $event) }}" onsubmit="return confirm('Delete this event and all its media?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
