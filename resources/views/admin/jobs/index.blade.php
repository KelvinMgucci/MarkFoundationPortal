@extends('layouts.admin')

@section('title', 'Job Postings')
@section('breadcrumb', 'Job Postings')

@section('content')

<div class="page-hd">
    <div>
        <h1>Job Postings</h1>
        <p>Manage all your recruitment listings.</p>
    </div>
    <a href="{{ route('admin.jobs.create') }}" class="btn btn-amber">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
        Add Posting
    </a>
</div>

<div class="card">
    @if($jobs->isEmpty())
        <div class="empty">
            <div class="empty__icon">💼</div>
            <h3>No job postings yet</h3>
            <p>Your postings will appear here once you create them.</p>
            <a href="{{ route('admin.jobs.create') }}" class="btn btn-amber" style="margin-top:.5rem;">Create First Posting</a>
        </div>
    @else
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Location</th>
                        <th>Type</th>
                        <th>Applications</th>
                        <th>Status</th>
                        <th>Posted</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jobs as $job)
                    <tr>
                        <td>
                            <span style="font-weight:600; color:var(--ink);">{{ $job->title }}</span>
                        </td>
                        <td>{{ $job->location }}</td>
                        <td>{{ $job->type }}</td>
                        <td>
                            @if($job->applications_count > 0)
                                <a href="{{ route('admin.applications.index', $job) }}"
                                   style="color:var(--amber-dk); font-weight:600; text-decoration:none;">
                                    {{ $job->applications_count }} {{ Str::plural('app', $job->applications_count) }}
                                </a>
                            @else
                                <span style="color:var(--ink-3);">None yet</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-{{ $job->status }}">
                                {{ ucfirst($job->status) }}
                            </span>
                        </td>
                        <td style="color:var(--ink-3); font-size:.82rem; white-space:nowrap;">
                            {{ $job->created_at->format('M j, Y') }}
                        </td>
                        <td>
                            <div class="actions">
                                {{-- Toggle status --}}
                                <form method="POST" action="{{ route('admin.jobs.toggle', $job) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-ghost btn-sm">
                                        {{ $job->isActive() ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>

                                <a href="{{ route('admin.jobs.edit', $job) }}" class="btn btn-ghost btn-sm">Edit</a>

                                @if($job->applications_count > 0)
                                    <a href="{{ route('admin.applications.index', $job) }}" class="btn btn-ghost btn-sm">
                                        Applications
                                    </a>
                                @endif

                                <form method="POST" action="{{ route('admin.jobs.destroy', $job) }}"
                                      onsubmit="return confirm('Delete this job? This will also remove all {{ $job->applications_count }} application(s).')">
                                    @csrf
                                    @method('DELETE')
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
