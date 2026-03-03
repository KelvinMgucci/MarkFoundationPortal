@extends('layouts.admin')

@section('title', 'Applications — ' . $job->title)
@section('breadcrumb')
    <a href="{{ route('admin.jobs.index') }}">Job Postings</a>
    <span class="sep">/</span>
    <span>Applications</span>
@endsection

@push('styles')
<style>
.status-select {
    padding: .3rem .6rem;
    border: 1px solid var(--border-dk);
    border-radius: 4px;
    font-family: var(--font-body);
    font-size: .78rem;
    font-weight: 500;
    color: var(--ink-2);
    background: var(--white);
    cursor: pointer;
    transition: border-color .2s;
}
.status-select:focus { outline: none; border-color: var(--amber); }
.save-status {
    padding: .3rem .65rem;
    background: var(--amber);
    color: var(--ink);
    border: none;
    border-radius: 4px;
    font-family: var(--font-body);
    font-size: .75rem;
    font-weight: 700;
    cursor: pointer;
    transition: background .2s;
}
.save-status:hover { background: var(--amber-dk); color: var(--white); }

.cover-letter-toggle {
    font-size: .78rem;
    color: var(--amber-dk);
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    background: none;
    border: none;
    padding: 0;
}
.cover-letter-toggle:hover { text-decoration: underline; }
.cover-letter-body {
    display: none;
    background: var(--cream);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: .875rem 1rem;
    font-size: .82rem;
    line-height: 1.75;
    color: var(--ink-2);
    white-space: pre-line;
    margin-top: .5rem;
    max-width: 540px;
}
</style>
@endpush

@section('content')

<div class="page-hd">
    <div>
        <h1>Applications</h1>
        <p>{{ $job->title }} · {{ $job->location }}</p>
    </div>
    <div style="display:flex; gap:.75rem; align-items:center; flex-wrap:wrap;">
        <span class="badge badge-{{ $job->status }}">{{ ucfirst($job->status) }}</span>
        <a href="{{ route('admin.jobs.index') }}" class="btn btn-ghost btn-sm">← Back to Jobs</a>
    </div>
</div>

{{-- Status summary pills --}}
@if($applications->count() > 0)
<div style="display:flex; gap:.625rem; flex-wrap:wrap; margin-bottom:1.5rem;">
    @foreach(App\Models\Application::STATUSES as $s)
        @php $n = $applications->where('status', $s)->count(); @endphp
        <div style="background:var(--white); border:1px solid var(--border); border-radius:var(--radius); padding:.45rem .875rem; font-size:.8rem;">
            <strong>{{ $n }}</strong> {{ ucfirst($s) }}
        </div>
    @endforeach
</div>
@endif

<div class="card">
    @if($applications->isEmpty())
        <div class="empty">
            <div class="empty__icon">📭</div>
            <h3>No applications yet</h3>
            <p>Applications will appear here once candidates start applying for this role.</p>
        </div>
    @else
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Applicant</th>
                        <th>Contact</th>
                        <th>Cover Letter</th>
                        <th>CV</th>
                        <th>Applied</th>
                        <th>Status</th>
                        <th>Update</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($applications as $app)
                    <tr>
                        <td>
                            <span style="font-weight:600; color:var(--ink);">{{ $app->full_name }}</span>
                        </td>
                        <td>
                            <div style="font-size:.82rem; line-height:1.9;">
                                <div>
                                    <a href="mailto:{{ $app->email }}"
                                       style="color:var(--amber-dk); text-decoration:none;">
                                        {{ $app->email }}
                                    </a>
                                </div>
                                <div style="color:var(--ink-3);">{{ $app->phone }}</div>
                            </div>
                        </td>
                        <td>
                            @if($app->cover_letter)
                                <button class="cover-letter-toggle"
                                        onclick="toggleCover({{ $app->id }})">
                                    View ↓
                                </button>
                                <div id="cover-{{ $app->id }}" class="cover-letter-body">
                                    {{ $app->cover_letter }}
                                </div>
                            @else
                                <span style="color:var(--ink-3); font-size:.8rem;">—</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.applications.cv', $app) }}"
                               class="btn btn-ghost btn-xs"
                               target="_blank">
                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                                Download
                            </a>
                        </td>
                        <td style="font-size:.8rem; color:var(--ink-3); white-space:nowrap;">
                            {{ $app->created_at->format('M j, Y') }}
                        </td>
                        <td>
                            <span class="badge badge-{{ $app->status }}">
                                {{ ucfirst($app->status) }}
                            </span>
                        </td>
                        <td>
                            <form method="POST"
                                  action="{{ route('admin.applications.status', $app) }}"
                                  style="display:flex; gap:.35rem; align-items:center;">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="status-select">
                                    @foreach(App\Models\Application::STATUSES as $s)
                                        <option value="{{ $s }}"
                                            {{ $app->status === $s ? 'selected' : '' }}>
                                            {{ ucfirst($s) }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="submit" class="save-status">Save</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<script>
function toggleCover(id) {
    const el = document.getElementById('cover-' + id);
    el.style.display = el.style.display === 'block' ? 'none' : 'block';
}
</script>
@endsection
