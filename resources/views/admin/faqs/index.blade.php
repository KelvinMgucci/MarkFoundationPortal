@extends('layouts.admin')
@section('title','FAQs')
@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;flex-wrap:wrap;gap:1rem;">
    <div><h1 style="font-size:1.5rem;font-family:var(--font-head);">FAQs</h1><p style="color:var(--ink-3);font-size:.85rem;">Frequently asked questions shown on the homepage.</p></div>
    <a href="{{ route('admin.faqs.create') }}" class="btn btn-primary">+ Add FAQ</a>
</div>
@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
<div class="card">
<table class="data-table">
<thead><tr><th>#</th><th>Question</th><th>Answer</th><th>Order</th><th>Visible</th><th>Actions</th></tr></thead>
<tbody>
@forelse($faqs as $f)
<tr>
    <td>{{ $loop->iteration }}</td>
    <td><strong>{{ $f->question }}</strong></td>
    <td style="color:var(--ink-3);font-size:.85rem;max-width:300px;">{{ Str::limit($f->answer, 80) }}</td>
    <td>{{ $f->sort_order }}</td>
    <td><span class="badge {{ $f->is_visible ? 'badge-visible' : 'badge-hidden' }}">{{ $f->is_visible ? 'Visible' : 'Hidden' }}</span></td>
    <td>
        <a href="{{ route('admin.faqs.edit', $f) }}" class="btn btn-sm btn-secondary">Edit</a>
        <form action="{{ route('admin.faqs.destroy', $f) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete?')">
            @csrf @method('DELETE')<button class="btn btn-sm btn-danger">Delete</button>
        </form>
    </td>
</tr>
@empty
<tr><td colspan="6" style="text-align:center;padding:2rem;color:var(--ink-3);">No FAQs yet. <a href="{{ route('admin.faqs.create') }}">Add one →</a></td></tr>
@endforelse
</tbody>
</table>
</div>
@endsection
