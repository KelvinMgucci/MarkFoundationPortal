@extends('layouts.admin')
@section('title','Gallery')
@section('breadcrumb','Gallery')

@section('content')
<div class="page-hd">
    <div><h1>Gallery</h1><p>Manage photos and videos shown on the public gallery page.</p></div>
    <a href="{{ route('admin.gallery.create') }}" class="btn btn-green">+ Add Item</a>
</div>
<div class="card">
    @if($items->isEmpty())
        <div class="empty">
            <div class="empty__icon">🖼</div>
            <h3>No gallery items yet</h3>
            <p>Add photos and videos to showcase your work.</p>
            <a href="{{ route('admin.gallery.create') }}" class="btn btn-green">Add First Item</a>
        </div>
    @else
        <div class="table-wrap">
            <table>
                <thead><tr><th>Preview</th><th>Title</th><th>Type</th><th>Visible</th><th>Added</th><th>Actions</th></tr></thead>
                <tbody>
                @foreach($items as $item)
                <tr>
                    <td style="width:72px">
                        @if($item->isPhoto() && $item->file_path)
                            <img src="{{ Storage::disk('public')->url($item->file_path) }}" style="width:60px;height:44px;object-fit:cover;border-radius:4px;border:1px solid var(--border)">
                        @else
                            <div style="width:60px;height:44px;background:var(--black);border-radius:4px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.2rem">▶</div>
                        @endif
                    </td>
                    <td style="font-weight:600">{{ $item->title }}</td>
                    <td><span class="badge {{ $item->isPhoto() ? 'badge-active' : 'badge-upcoming' }}">{{ ucfirst($item->type) }}</span></td>
                    <td>
                        <span class="badge {{ $item->is_visible ? 'badge-visible' : 'badge-hidden' }}">
                            {{ $item->is_visible ? 'Visible' : 'Hidden' }}
                        </span>
                    </td>
                    <td style="font-size:.8rem;color:var(--ink-3)">{{ $item->created_at->format('M j, Y') }}</td>
                    <td>
                        <div class="actions">
                            <form method="POST" action="{{ route('admin.gallery.toggle', $item) }}">@csrf
                                <button class="btn btn-ghost btn-sm">{{ $item->is_visible ? 'Hide' : 'Show' }}</button>
                            </form>
                            <a href="{{ route('admin.gallery.edit', $item) }}" class="btn btn-ghost btn-sm">Edit</a>
                            <form method="POST" action="{{ route('admin.gallery.destroy', $item) }}" onsubmit="return confirm('Delete this item?')">@csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm">Delete</button>
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
