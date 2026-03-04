@extends('layouts.admin')
@section('title','Edit Team Member')
@section('content')
<div style="margin-bottom:1.5rem;"><a href="{{ route('admin.team.index') }}" style="color:var(--green);font-size:.85rem;">← Back to Team</a><h1 style="font-size:1.5rem;font-family:var(--font-head);margin-top:.5rem;">Edit: {{ $team->name }}</h1></div>
<style>.aform{background:#fff;border:1px solid var(--border);border-radius:12px;padding:2rem;max-width:720px;}.fg{margin-bottom:1.25rem;}.fg label{display:block;font-size:.82rem;font-weight:600;color:var(--ink-2);margin-bottom:.4rem;}.fg input,.fg textarea{width:100%;padding:.65rem .9rem;border:1px solid var(--border-dk);border-radius:6px;font-family:var(--font-body);font-size:.9rem;color:var(--ink);}.fg input:focus,.fg textarea:focus{outline:none;border-color:var(--green);}.fg textarea{resize:vertical;min-height:110px;}.row2{display:grid;grid-template-columns:1fr 1fr;gap:1rem;}.hint{font-size:.76rem;color:var(--ink-3);margin-top:.25rem;}</style>
<form action="{{ route('admin.team.update', $team) }}" method="POST" enctype="multipart/form-data" class="aform">
    @csrf @method('PUT')
    <div class="fg"><label>Full Name *</label><input type="text" name="name" value="{{ old('name',$team->name) }}" required></div>
    <div class="fg"><label>Role / Title *</label><input type="text" name="role" value="{{ old('role',$team->role) }}" required></div>
    <div class="fg"><label>Bio</label><textarea name="bio">{{ old('bio',$team->bio) }}</textarea></div>
    <div class="row2">
        <div class="fg"><label>Email</label><input type="email" name="email" value="{{ old('email',$team->email) }}"></div>
        <div class="fg"><label>Phone</label><input type="text" name="phone" value="{{ old('phone',$team->phone) }}"></div>
    </div>
    <div class="row2">
        <div class="fg"><label>Photo</label>
            @if($team->photo)<div style="margin-bottom:.5rem;"><img src="{{ Storage::url($team->photo) }}" style="height:60px;border-radius:50%;"></div>@endif
            <input type="file" name="photo" accept="image/*"><p class="hint">Leave blank to keep current photo</p>
        </div>
        <div class="fg"><label>Sort Order</label><input type="number" name="sort_order" value="{{ old('sort_order',$team->sort_order) }}"></div>
    </div>
    <div class="fg" style="display:flex;align-items:center;gap:.5rem;"><input type="checkbox" name="is_visible" value="1" id="vis" {{ $team->is_visible ? 'checked' : '' }}><label for="vis" style="margin:0;">Visible on website</label></div>
    @if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif
    <div style="display:flex;gap:.75rem;margin-top:1.5rem;">
        <button type="submit" class="btn btn-primary">Update Member</button>
        <a href="{{ route('admin.team.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</form>
@endsection
