@extends('layouts.admin')
@section('title','Edit Gallery Item')
@section('breadcrumb')<a href="{{ route('admin.gallery.index') }}">Gallery</a><span class="sep">/</span><span>Edit</span>@endsection

@section('content')
<div class="page-hd"><div><h1>Edit Gallery Item</h1><p>{{ $gallery->title }}</p></div></div>
<div class="card"><div class="card-body">
<form method="POST" action="{{ route('admin.gallery.update', $gallery) }}" enctype="multipart/form-data">
@csrf @method('PUT')
<div class="form-group">
    <label class="form-label">Type</label>
    <span class="badge {{ $gallery->isPhoto() ? 'badge-active' : 'badge-upcoming' }}" style="font-size:.85rem;padding:.3rem .8rem">{{ ucfirst($gallery->type) }}</span>
</div>
<div class="form-group">
    <label class="form-label" for="title">Title <span class="req">*</span></label>
    <input id="title" name="title" type="text" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $gallery->title) }}">
    @error('title')<p class="form-error">{{ $message }}</p>@enderror
</div>
<div class="form-group">
    <label class="form-label">Description</label>
    <textarea name="description" rows="3" class="form-control">{{ old('description', $gallery->description) }}</textarea>
</div>
@if($gallery->isPhoto())
    @if($gallery->file_path)
    <div class="form-group">
        <label class="form-label">Current Photo</label>
        <img src="{{ Storage::disk('public')->url($gallery->file_path) }}" style="max-width:240px;border-radius:var(--radius);border:1px solid var(--border);display:block;margin-bottom:.5rem">
    </div>
    @endif
    <div class="form-group">
        <label class="form-label">Replace Photo</label>
        <input name="photo" type="file" accept="image/jpeg,image/png,image/webp" class="form-control">
        <p class="form-hint">Leave blank to keep current photo</p>
    </div>
@else
    <div class="form-group">
        <label class="form-label">Video URL</label>
        <input name="video_url" type="url" class="form-control" value="{{ old('video_url', $gallery->video_url) }}">
    </div>
@endif
<div class="form-group" style="display:flex;align-items:center;gap:.625rem">
    <input type="checkbox" id="is_visible" name="is_visible" value="1" {{ old('is_visible', $gallery->is_visible) ? 'checked' : '' }} style="width:16px;height:16px;accent-color:var(--green)">
    <label for="is_visible" style="margin:0;font-size:.875rem;cursor:pointer">Visible on public gallery</label>
</div>
<div style="display:flex;gap:.75rem;justify-content:flex-end;padding-top:.75rem;border-top:1px solid var(--border)">
    <a href="{{ route('admin.gallery.index') }}" class="btn btn-ghost">Cancel</a>
    <button type="submit" class="btn btn-green">Save Changes</button>
</div>
</form>
</div></div>
@endsection
