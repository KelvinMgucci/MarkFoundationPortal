@extends('layouts.admin')
@section('title','Impact Stats')
@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;flex-wrap:wrap;gap:1rem;">
    <div><h1 style="font-size:1.5rem;font-family:var(--font-head);">Impact Stats</h1><p style="color:var(--ink-3);font-size:.85rem;">The animated counter numbers shown on the homepage.</p></div>
    <a href="{{ route('admin.stats.create') }}" class="btn btn-primary">+ Add Stat</a>
</div>
@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
<div class="card">
<table class="data-table">
<thead><tr><th>Icon</th><th>Label</th><th>Value</th><th>Suffix</th><th>Order</th><th>Visible</th><th>Actions</th></tr></thead>
<tbody>
@forelse($stats as $s)
<tr>
    <td style="font-size:1.5rem;">{{ $s->icon }}</td>
    <td><strong>{{ $s->label }}</strong></td>
    <td style="font-family:var(--font-head);font-size:1.25rem;color:var(--green);">{{ number_format($s->value) }}</td>
    <td>{{ $s->suffix }}</td>
    <td>{{ $s->sort_order }}</td>
    <td><span class="badge {{ $s->is_visible ? 'badge-visible' : 'badge-hidden' }}">{{ $s->is_visible ? 'Visible' : 'Hidden' }}</span></td>
    <td>
        <a href="{{ route('admin.stats.edit', $s) }}" class="btn btn-sm btn-secondary">Edit</a>
        <form action="{{ route('admin.stats.destroy', $s) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete?')">
            @csrf @method('DELETE')<button class="btn btn-sm btn-danger">Delete</button>
        </form>
    </td>
</tr>
@empty
<tr><td colspan="7" style="text-align:center;padding:2rem;color:var(--ink-3);">No stats yet. <a href="{{ route('admin.stats.create') }}">Add one →</a></td></tr>
@endforelse
</tbody>
</table>
</div>
@endsection
