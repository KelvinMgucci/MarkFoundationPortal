@extends('layouts.admin')
@section('title','Team Members')
@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;flex-wrap:wrap;gap:1rem;">
    <div><h1 style="font-size:1.5rem;font-family:var(--font-head);">Team Members</h1><p style="color:var(--ink-3);font-size:.85rem;">Manage the team shown on the public website.</p></div>
    <a href="{{ route('admin.team.create') }}" class="btn btn-primary">+ Add Member</a>
</div>
@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
<div class="card">
<table class="data-table">
<thead><tr><th>Photo</th><th>Name</th><th>Role</th><th>Contact</th><th>Order</th><th>Visible</th><th>Actions</th></tr></thead>
<tbody>
@forelse($members as $m)
<tr>
    <td><div style="width:44px;height:44px;border-radius:50%;background:var(--sidebar-bg);display:flex;align-items:center;justify-content:center;overflow:hidden;font-size:1.3rem;">
        @if($m->photo)<img src="{{ Storage::url($m->photo) }}" style="width:100%;height:100%;object-fit:cover;">@else👤@endif
    </div></td>
    <td><strong>{{ $m->name }}</strong></td>
    <td><span class="badge badge-published">{{ $m->role }}</span></td>
    <td style="font-size:.8rem;">
        @if($m->email)<div>✉ {{ $m->email }}</div>@endif
        @if($m->phone)<div>📞 {{ $m->phone }}</div>@endif
    </td>
    <td>{{ $m->sort_order }}</td>
    <td><span class="badge {{ $m->is_visible ? 'badge-visible' : 'badge-hidden' }}">{{ $m->is_visible ? 'Visible' : 'Hidden' }}</span></td>
    <td>
        <a href="{{ route('admin.team.edit', $m) }}" class="btn btn-sm btn-secondary">Edit</a>
        <form action="{{ route('admin.team.destroy', $m) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this member?')">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-danger">Delete</button>
        </form>
    </td>
</tr>
@empty
<tr><td colspan="7" style="text-align:center;padding:2rem;color:var(--ink-3);">No team members yet. <a href="{{ route('admin.team.create') }}">Add one →</a></td></tr>
@endforelse
</tbody>
</table>
</div>
@endsection
