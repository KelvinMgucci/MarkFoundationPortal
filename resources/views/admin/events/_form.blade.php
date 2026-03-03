{{-- Shared event form partial. Expects: $event (on edit) --}}
<div class="card">
    <div class="card-body">

        <div class="form-row">
            <div class="form-group" style="grid-column:1/-1;">
                <label class="form-label" for="title">Title <span class="req">*</span></label>
                <input id="title" name="title" type="text"
                    class="form-control @error('title') is-invalid @enderror"
                    value="{{ old('title', $event->title ?? '') }}"
                    placeholder="e.g. Annual Community Day 2025">
                @error('title')<p class="form-error">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="description">Description <span class="req">*</span></label>
            <textarea id="description" name="description" rows="5"
                class="form-control @error('description') is-invalid @enderror"
                placeholder="Describe the event...">{{ old('description', $event->description ?? '') }}</textarea>
            @error('description')<p class="form-error">{{ $message }}</p>@enderror
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="start_date">Start Date &amp; Time <span class="req">*</span></label>
                <input id="start_date" name="start_date" type="datetime-local"
                    class="form-control @error('start_date') is-invalid @enderror"
                    value="{{ old('start_date', isset($event->start_date) ? $event->start_date->format('Y-m-d\TH:i') : '') }}">
                @error('start_date')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="end_date">End Date &amp; Time</label>
                <input id="end_date" name="end_date" type="datetime-local"
                    class="form-control @error('end_date') is-invalid @enderror"
                    value="{{ old('end_date', isset($event->end_date) ? $event->end_date?->format('Y-m-d\TH:i') : '') }}">
                @error('end_date')<p class="form-error">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="location">Location / Venue</label>
                <input id="location" name="location" type="text"
                    class="form-control @error('location') is-invalid @enderror"
                    value="{{ old('location', $event->location ?? '') }}"
                    placeholder="e.g. Katesh Community Hall">
                @error('location')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="rsvp_link">RSVP / Registration Link</label>
                <input id="rsvp_link" name="rsvp_link" type="url"
                    class="form-control @error('rsvp_link') is-invalid @enderror"
                    value="{{ old('rsvp_link', $event->rsvp_link ?? '') }}"
                    placeholder="https://...">
                @error('rsvp_link')<p class="form-error">{{ $message }}</p>@enderror
            </div>
        </div>

        {{-- Cover Image --}}
        <div class="form-group">
            <label class="form-label">Cover Image</label>
            @if(isset($event) && $event->cover_image_path)
                <img src="{{ Storage::url($event->cover_image_path) }}"
                     style="max-width:280px;border-radius:var(--radius);border:1px solid var(--border);display:block;margin-bottom:.625rem;">
                <p class="form-hint" style="margin-bottom:.375rem;">Upload a new image to replace the current one.</p>
            @endif
            <input name="cover_image" type="file" accept="image/jpeg,image/png,image/webp" class="form-control">
            <p class="form-hint">JPG / PNG / WebP · max 5 MB</p>
        </div>

        {{-- Photo Uploads --}}
        <div class="form-group">
            <label class="form-label">Upload Photos</label>
            <input name="photos[]" type="file" multiple accept="image/jpeg,image/png,image/webp" class="form-control">
            <p class="form-hint">Select multiple photos at once. JPG / PNG / WebP · max 5 MB each.</p>
        </div>

        {{-- Video URLs --}}
        <div class="form-group">
            <label class="form-label" for="video_urls">Video URLs</label>
            <textarea id="video_urls" name="video_urls" rows="4" class="form-control"
                placeholder="Paste one YouTube or Vimeo URL per line&#10;https://www.youtube.com/watch?v=...&#10;https://vimeo.com/...">{{ old('video_urls') }}</textarea>
            <p class="form-hint">One URL per line. YouTube and Vimeo links are supported.</p>
        </div>

        {{-- Status --}}
        <div class="form-group" style="display:flex;align-items:center;gap:.625rem;">
            <input type="checkbox" id="is_published" name="is_published" value="1"
                {{ old('is_published', $event->is_published ?? true) ? 'checked' : '' }}
                style="width:16px;height:16px;accent-color:var(--green);">
            <label for="is_published" style="margin:0;font-size:.875rem;cursor:pointer;">Published — visible on public site</label>
        </div>

        {{-- Existing media (edit mode) --}}
        @if(isset($event) && $event->media->count() > 0)
        <div style="border-top:1px solid var(--border);padding-top:1.25rem;margin-top:.5rem;">
            <p style="font-size:.82rem;font-weight:700;color:var(--ink-2);margin-bottom:.875rem;text-transform:uppercase;letter-spacing:.05em;">
                Existing Media ({{ $event->media->count() }} items) — click ✕ to remove
            </p>
            <div style="display:grid;grid-template-columns:repeat(5,1fr);gap:.625rem;">
                @foreach($event->media as $media)
                <div style="position:relative;border-radius:var(--radius);overflow:hidden;border:1px solid var(--border);">
                    @if($media->isPhoto())
                        <img src="{{ Storage::url($media->file_path) }}"
                             style="width:100%;aspect-ratio:1;object-fit:cover;display:block;">
                    @else
                        <div style="aspect-ratio:1;background:var(--black);display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.5rem;">▶</div>
                    @endif
                    <form method="POST" action="{{ route('admin.events.media.destroy', $media) }}"
                          onsubmit="return confirm('Remove this media item?')"
                          style="position:absolute;top:3px;right:3px;">
                        @csrf @method('DELETE')
                        <button type="submit"
                            style="background:rgba(185,28,28,.85);color:#fff;border:none;border-radius:50%;width:22px;height:22px;font-size:.75rem;cursor:pointer;display:flex;align-items:center;justify-content:center;line-height:1;">
                            ✕
                        </button>
                    </form>
                    @if($media->isVideo())
                        <div style="position:absolute;bottom:3px;left:3px;background:rgba(0,0,0,.6);color:rgba(255,255,255,.8);font-size:.65rem;padding:.1rem .35rem;border-radius:3px;">VIDEO</div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>

    <div style="padding:1.125rem 1.5rem;border-top:1px solid var(--border);display:flex;gap:.75rem;justify-content:flex-end;">
        <a href="{{ route('admin.events.index') }}" class="btn btn-ghost">Cancel</a>
        <button type="submit" class="btn btn-green">
            {{ isset($event) ? 'Save Changes' : 'Create Event' }}
        </button>
    </div>
</div>
