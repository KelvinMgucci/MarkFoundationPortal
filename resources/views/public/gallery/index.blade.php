@extends('layouts.public')
@section('title', 'Gallery - Mark Foundation')

@push('styles')
<style>
.page-banner {
    background:linear-gradient(135deg,var(--green-dk) 0%,var(--green) 100%);
    padding:3.5rem 0 4rem;margin-bottom:3rem;position:relative;overflow:hidden;
}
.page-banner::after { content:'';position:absolute;bottom:-1px;left:0;right:0;height:60px;background:var(--cream);clip-path:ellipse(55% 100% at 50% 100%); }
.page-banner::before { content:'';position:absolute;inset:0;background:radial-gradient(ellipse 50% 100% at 90% 50%,rgba(240,192,48,.2) 0%,transparent 60%); }
.page-banner__inner { position:relative;z-index:1;text-align:center; }
.page-banner h1 { font-size:clamp(1.75rem,4vw,3rem);color:var(--white);margin-bottom:.5rem; }
.page-banner p  { color:rgba(255,255,255,.7);font-size:1rem; }

/* Tabs */
.gallery-tabs { display:flex;gap:.5rem;justify-content:center;margin-bottom:2.5rem;flex-wrap:wrap; }
.gallery-tab {
    padding:.55rem 1.5rem;border-radius:99px;font-size:.875rem;font-weight:600;
    border:2px solid var(--border-dk);background:var(--white);color:var(--ink-2);
    cursor:pointer;transition:all .2s;
}
.gallery-tab.active,
.gallery-tab:hover { background:var(--green);color:var(--white);border-color:var(--green); }

/* Grid */
.gallery-grid { display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;margin-bottom:2rem; }
@media(max-width:900px){.gallery-grid{grid-template-columns:repeat(3,1fr);}}
@media(max-width:600px){.gallery-grid{grid-template-columns:repeat(2,1fr);}}

.gallery-card {
    border-radius:var(--radius);overflow:hidden;background:var(--white);
    border:1px solid var(--border);transition:all .25s;cursor:pointer;
}
.gallery-card:hover { box-shadow:var(--shadow-lg);transform:translateY(-3px); }
.gallery-card__thumb {
    aspect-ratio:1;overflow:hidden;background:var(--green-lt);
    display:flex;align-items:center;justify-content:center;position:relative;
}
.gallery-card__thumb img { width:100%;height:100%;object-fit:cover;transition:transform .4s; }
.gallery-card:hover .gallery-card__thumb img { transform:scale(1.07); }
.gallery-card__thumb .play-badge {
    position:absolute;inset:0;background:rgba(0,0,0,.5);
    display:flex;align-items:center;justify-content:center;
    font-size:2.5rem;color:#fff;
}
.gallery-card__info { padding:.875rem; }
.gallery-card__info h3 { font-size:.9rem;font-weight:600;margin-bottom:.2rem;color:var(--ink); }
.gallery-card__info p  { font-size:.78rem;color:var(--ink-3);line-height:1.5; }

/* Lightbox */
.lightbox {
    position:fixed;inset:0;background:rgba(0,0,0,.92);z-index:9999;
    display:none;align-items:center;justify-content:center;padding:1.5rem;
}
.lightbox.open { display:flex; }
.lightbox__close {
    position:absolute;top:1rem;right:1.25rem;background:none;border:none;
    color:#fff;font-size:2rem;cursor:pointer;line-height:1;z-index:1;
}
.lightbox__media { max-width:90vw;max-height:80vh;border-radius:var(--radius); }
.lightbox__media img { max-width:90vw;max-height:80vh;border-radius:var(--radius);display:block; }
.lightbox__media iframe { width:80vw;max-width:900px;height:50vw;max-height:500px;border-radius:var(--radius); }
.lightbox__caption { position:absolute;bottom:2rem;left:50%;transform:translateX(-50%);color:#fff;text-align:center;font-size:.9rem; }

.empty-state { text-align:center;padding:4rem 2rem;color:var(--ink-3); }
.empty-state p { font-size:2.5rem;margin-bottom:1rem; }
</style>
@endpush

@section('content')
<div class="page-banner">
    <div class="wrap page-banner__inner">
        <h1>Photo & Video Gallery</h1>
        <p>Moments from our work, events, and communities across Tanzania.</p>
    </div>
</div>

<div class="wrap page-main">

    <div class="gallery-tabs">
        <button class="gallery-tab active" onclick="filterGallery('all',this)">All ({{ $photos->count() + $videos->count() }})</button>
        <button class="gallery-tab" onclick="filterGallery('photo',this)">📷 Photos ({{ $photos->count() }})</button>
        <button class="gallery-tab" onclick="filterGallery('video',this)">🎥 Videos ({{ $videos->count() }})</button>
    </div>

    @if($photos->isEmpty() && $videos->isEmpty())
        <div class="empty-state">
            <p>📷</p>
            <h3 style="font-size:1.2rem;margin-bottom:.5rem;">No gallery items yet</h3>
            <p>Check back soon for photos and videos from our work.</p>
        </div>
    @else
        <div class="gallery-grid" id="galleryGrid">
            @foreach($photos as $item)
            <div class="gallery-card" data-type="photo" onclick="openLightbox('photo','{{ $item->file_path ? Storage::url($item->file_path) : '' }}','{{ addslashes($item->title) }}')">
                <div class="gallery-card__thumb">
                    @if($item->file_path)
                        <img src="{{ Storage::url($item->file_path) }}" alt="{{ $item->title }}" loading="lazy">
                    @else
                        <span style="font-size:3rem;">📷</span>
                    @endif
                </div>
                <div class="gallery-card__info">
                    <h3>{{ $item->title }}</h3>
                    @if($item->description)<p>{{ Str::limit($item->description, 60) }}</p>@endif
                </div>
            </div>
            @endforeach

            @foreach($videos as $item)
            <div class="gallery-card" data-type="video" onclick="openLightbox('video','{{ $item->embedUrl() ?? '' }}','{{ addslashes($item->title) }}')">
                <div class="gallery-card__thumb" style="background:#111;">
                    @if($item->file_path)
                        <video src="{{ Storage::url($item->file_path) }}" style="width:100%;height:100%;object-fit:cover;" muted></video>
                    @endif
                    <div class="play-badge">▶</div>
                </div>
                <div class="gallery-card__info">
                    <h3>{{ $item->title }}</h3>
                    @if($item->description)<p>{{ Str::limit($item->description, 60) }}</p>@endif
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>

{{-- Lightbox --}}
<div class="lightbox" id="lightbox" onclick="closeLightbox(event)">
    <button class="lightbox__close" onclick="closeLightbox()">✕</button>
    <div class="lightbox__media" id="lightboxMedia"></div>
    <div class="lightbox__caption" id="lightboxCaption"></div>
</div>

<script>
function filterGallery(type, btn) {
    document.querySelectorAll('.gallery-tab').forEach(t => t.classList.remove('active'));
    btn.classList.add('active');
    document.querySelectorAll('#galleryGrid .gallery-card').forEach(card => {
        card.style.display = (type === 'all' || card.dataset.type === type) ? '' : 'none';
    });
}
function openLightbox(type, src, title) {
    const lb = document.getElementById('lightbox');
    const media = document.getElementById('lightboxMedia');
    const cap = document.getElementById('lightboxCaption');
    cap.textContent = title;
    if (type === 'photo') {
        media.innerHTML = `<img src="${src}" alt="${title}">`;
    } else {
        if (src.includes('youtube.com/embed') || src.includes('player.vimeo')) {
            media.innerHTML = `<iframe src="${src}" frameborder="0" allowfullscreen allow="autoplay"></iframe>`;
        } else {
            media.innerHTML = `<video src="${src}" controls style="max-width:90vw;max-height:80vh;border-radius:8px;"></video>`;
        }
    }
    lb.classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeLightbox(e) {
    if (!e || e.target === document.getElementById('lightbox') || e.target.classList.contains('lightbox__close')) {
        document.getElementById('lightbox').classList.remove('open');
        document.getElementById('lightboxMedia').innerHTML = '';
        document.body.style.overflow = '';
    }
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeLightbox(); });
</script>
@endsection
