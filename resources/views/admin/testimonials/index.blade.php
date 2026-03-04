@extends('layouts.admin')
@section('title','Testimonials')
@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;flex-wrap:wrap;gap:1rem;">
    <div><h1 style="font-size:1.5rem;font-family:var(--font-head);">Testimonials</h1><p style="color:var(--ink-3);font-size:.85rem;">Community voices shown on the homepage.</p></div>
    <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary">+ Add Testimonial</a>
</div>
@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
<div class="card">
<table class="data-table">
<thead><tr><th>Quote</th><th>Author</th><th>Location</th><th>Order</th><th>Visible</th><th>Actions</th></tr></thead>
<tbody>
@forelse($testimonials as $t)
<tr>
    <td style="max-width:320px;font-style:italic;color:var(--ink-2);">"{{ Str::limit($t->quote, 100) }}"</td>
    <td><strong>{{ $t->author_name }}</strong></td>
    <td>{{ $t->author_location }}</td>
    <td>{{ $t->sort_order }}</td>
    <td><span class="badge {{ $t->is_visible ? 'badge-visible' : 'badge-hidden' }}">{{ $t->is_visible ? 'Visible' : 'Hidden' }}</span></td>
    <td>
        <a href="{{ route('admin.testimonials.edit', $t) }}" class="btn btn-sm btn-secondary">Edit</a>
        <form action="{{ route('admin.testimonials.destroy', $t) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete?')">
            @csrf @method('DELETE')<button class="btn btn-sm btn-danger">Delete</button>
        </form>
    </td>
</tr>
@empty
<tr><td colspan="6" style="text-align:center;padding:2rem;color:var(--ink-3);">No testimonials yet. <a href="{{ route('admin.testimonials.create') }}">Add one →</a></td></tr>
@endforelse
</tbody>
</table>
</div>
@endsection
