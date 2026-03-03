@extends('layouts.admin')
@section('title','Add Gallery Item')
@section('breadcrumb')<a href="{{ route('admin.gallery.index') }}">Gallery</a><span class="sep">/</span><span>Add</span>@endsection

@section('content')
<div class="page-hd"><div><h1>Add Gallery Item</h1></div></div>
<div class="card"><div class="card-body">
<form method="POST" action="{{ route('admin.gallery.store') }}" enctype="multipart/form-data">
@csrf
<div class="form-group">
    <label class="form-label">Type <span class="req">*</span></label>
    <div style="display:flex;gap:1rem;margin-top:.25rem">
        <label style="display:flex;align-items:center;gap:.5rem;cursor:pointer;font-size:.9rem">
            <input type="radio" name="type" value="photo" {{ old('type','photo')==='photo'?'checked':'' }} onchange="toggleType(this.value)"> 📷 Photo
        </label>
        <label style="display:flex;align-items:center;gap:.5rem;cursor:pointer;font-size:.9rem">
            <input type="radio" name="type" value="video" {{ old('type')==='video'?'checked':'' }} onchange="toggleType(this.value)"> 🎬 Video (YouTube/Vimeo)
        </label>
    </div>
</div>
<div class="form-group">
    <label class="form-label" for="title">Title <span class="req">*</span></label>
    <input id="title" name="title" type="text" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="e.g. Community Day 2024">
    @error('title')<p class="form-error">{{ $message }}</p>@enderror
</div>
<div class="form-group">
    <label class="form-label" for="description">Description</label>
    <textarea id="description" name="description" rows="3" class="form-control" placeholder="Optional caption or description...">{{ old('description') }}</textarea>
</div>
<div id="photo-field" class="form-group">
    <label class="form-label">Photo <span class="req">*</span></label>
    <input name="photo" type="file" accept="image/jpeg,image/png,image/webp" class="form-control @error('photo') is-invalid @enderror">
    <p class="form-hint">JPG, PNG or WebP · max 5 MB</p>
    @error('photo')<p class="form-error">{{ $message }}</p>@enderror
</div>
<div id="video-field" class="form-group" style="display:none">
    <label class="form-label" for="video_url">Video URL <span class="req">*</span></label>
    <input id="video_url" name="video_url" type="url" class="form-control @error('video_url') is-invalid @enderror" value="{{ old('video_url') }}" placeholder="https://www.youtube.com/watch?v=...">
    <p class="form-hint">Paste a YouTube or Vimeo URL</p>
    @error('video_url')<p class="form-error">{{ $message }}</p>@enderror
</div>
<div class="form-group" style="display:flex;align-items:center;gap:.625rem">
    <input type="checkbox" id="is_visible" name="is_visible" value="1" {{ old('is_visible',true) ? 'checked' : '' }} style="width:16px;height:16px;accent-color:var(--green)">
    <label for="is_visible" style="margin:0;font-size:.875rem;cursor:pointer">Visible on public gallery</label>
</div>
<div style="display:flex;gap:.75rem;justify-content:flex-end;padding-top:.75rem;border-top:1px solid var(--border)">
    <a href="{{ route('admin.gallery.index') }}" class="btn btn-ghost">Cancel</a>
    <button type="submit" class="btn btn-green">Add to Gallery</button>
</div>
</form>
</div></div>
<script>
function toggleType(v){
    document.getElementById('photo-field').style.display = v==='photo'?'block':'none';
    document.getElementById('video-field').style.display = v==='video'?'block':'none';
}
toggleType('{{ old("type","photo") }}');
</script>
@endsection
