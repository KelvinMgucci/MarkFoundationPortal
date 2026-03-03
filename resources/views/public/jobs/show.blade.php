@extends('layouts.public')

@section('title', $job->title)

@push('styles')
<style>
.job-layout {
    display: grid;
    grid-template-columns: 1fr 380px;
    gap: 2.5rem;
    align-items: start;
}
@media (max-width: 900px) { .job-layout { grid-template-columns: 1fr; } }

.back-link {
    display: inline-flex;
    align-items: center;
    gap: .35rem;
    font-size: .82rem;
    font-weight: 500;
    color: var(--ink-3);
    text-decoration: none;
    margin-bottom: 1.5rem;
    transition: color .2s;
}
.back-link:hover { color: var(--amber-dk); }

/* Job detail panel */
.job-hd {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    padding: 2rem;
    margin-bottom: 1.5rem;
}
.job-hd h1 { font-size: clamp(1.5rem, 3vw, 2.25rem); margin-bottom: 1rem; }
.job-hd__meta { display: flex; gap: .75rem; flex-wrap: wrap; }
.section-block {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    padding: 1.75rem;
    margin-bottom: 1.25rem;
}
.section-block h2 {
    font-size: 1.05rem;
    margin-bottom: 1rem;
    padding-bottom: .875rem;
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    gap: .5rem;
}
.prose { font-size: .9rem; color: var(--ink-2); line-height: 1.85; white-space: pre-line; }

/* Sidebar */
.sidebar-sticky { position: sticky; top: 84px; }
.overview-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    padding: 1.5rem;
    margin-bottom: 1.25rem;
}
.overview-card h3 { font-size: .95rem; margin-bottom: 1rem; padding-bottom: .75rem; border-bottom: 1px solid var(--border); }
.overview-row { display: flex; flex-direction: column; gap: .875rem; }
.overview-item__label {
    font-size: .7rem;
    font-weight: 700;
    letter-spacing: .07em;
    text-transform: uppercase;
    color: var(--ink-3);
    margin-bottom: .2rem;
}
.overview-item__value { font-size: .9rem; font-weight: 500; color: var(--ink); }

/* Application form */
.apply-card {
    background: var(--white);
    border: 2px solid var(--amber);
    border-radius: var(--radius-lg);
    padding: 1.75rem;
}
.apply-card__head { margin-bottom: 1.5rem; }
.apply-card__head h3 { font-size: 1.15rem; margin-bottom: .25rem; }
.apply-card__head p  { font-size: .82rem; color: var(--ink-3); }

.form-group { margin-bottom: 1.1rem; }
.form-label { display: block; font-size: .82rem; font-weight: 600; color: var(--ink-2); margin-bottom: .375rem; }
.form-label .req { color: var(--amber-dk); }
.form-control {
    width: 100%;
    padding: .625rem .875rem;
    border: 1.5px solid var(--border-dk);
    border-radius: var(--radius);
    font-family: var(--font-body);
    font-size: .875rem;
    color: var(--ink);
    background: var(--white);
    transition: border-color .2s, box-shadow .2s;
}
.form-control:focus {
    outline: none;
    border-color: var(--amber);
    box-shadow: 0 0 0 3px rgba(232,160,32,.15);
}
.form-control.is-invalid { border-color: #b91c1c; }
.form-error { font-size: .78rem; color: #b91c1c; margin-top: .3rem; }
.form-hint  { font-size: .75rem; color: var(--ink-3); margin-top: .3rem; }
textarea.form-control { resize: vertical; line-height: 1.65; }

.file-drop {
    border: 2px dashed var(--border-dk);
    border-radius: var(--radius);
    padding: 1.375rem;
    text-align: center;
    cursor: pointer;
    transition: border-color .2s, background .2s;
}
.file-drop:hover { border-color: var(--amber); background: var(--amber-lt); }
.file-drop input { display: none; }
.file-drop__icon { font-size: 1.5rem; margin-bottom: .5rem; }
.file-drop__label { font-size: .82rem; font-weight: 600; color: var(--ink-2); }
.file-drop__sub   { font-size: .75rem; color: var(--ink-3); margin-top: .2rem; }

.submit-btn {
    width: 100%;
    padding: .875rem 1.5rem;
    background: var(--amber);
    color: var(--ink);
    border: none;
    border-radius: var(--radius);
    font-family: var(--font-body);
    font-size: .95rem;
    font-weight: 700;
    cursor: pointer;
    transition: background .2s, color .2s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: .5rem;
    margin-top: .25rem;
}
.submit-btn:hover { background: var(--amber-dk); color: var(--white); }
</style>
@endpush

@section('content')

<a href="{{ route('jobs.index') }}" class="back-link">
    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
    All open positions
</a>

<div class="job-layout">

    {{-- LEFT: Job description ─────────────────────────────────────────── --}}
    <div>
        <div class="job-hd">
            <h1>{{ $job->title }}</h1>
            <div class="job-hd__meta">
                <span class="pill">📍 {{ $job->location }}</span>
                <span class="pill pill-amber">{{ $job->type }}</span>
            </div>
        </div>

        <div class="section-block">
            <h2>
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.586a1 1 0 0 1 .707.293l5.414 5.414a1 1 0 0 1 .293.707V19a2 2 0 0 1-2 2z"/></svg>
                About this role
            </h2>
            <div class="prose">{{ $job->description }}</div>
        </div>

        @if($job->responsibilities)
        <div class="section-block">
            <h2>
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                Responsibilities
            </h2>
            <div class="prose">{{ $job->responsibilities }}</div>
        </div>
        @endif

        <div class="section-block">
            <h2>
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
                Requirements
            </h2>
            <div class="prose">{{ $job->requirements }}</div>
        </div>

        {{-- Application form (mobile: inline; desktop: sidebar) --}}
        @if(session('success'))
            <div class="alert alert-success" role="alert">
                <svg width="16" height="16" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                {{ session('success') }}
            </div>
        @endif
    </div>

    {{-- RIGHT: Sidebar ─────────────────────────────────────────────────── --}}
    <div class="sidebar-sticky">
        <div class="overview-card">
            <h3>Job overview</h3>
            <div class="overview-row">
                <div>
                    <p class="overview-item__label">Location</p>
                    <p class="overview-item__value">{{ $job->location }}</p>
                </div>
                <div>
                    <p class="overview-item__label">Type</p>
                    <p class="overview-item__value">{{ $job->type }}</p>
                </div>
                <div>
                    <p class="overview-item__label">Posted</p>
                    <p class="overview-item__value">{{ $job->created_at->diffForHumans() }}</p>
                </div>
            </div>
        </div>

        {{-- Application Form --}}
        <div class="apply-card" id="apply">
            <div class="apply-card__head">
                <h3>Apply for this role</h3>
                <p>Fields marked <span style="color:var(--amber-dk);">*</span> are required.</p>
            </div>

            <form method="POST"
                  action="{{ route('jobs.apply', $job) }}"
                  enctype="multipart/form-data"
                  novalidate>
                @csrf

                {{-- Full Name --}}
                <div class="form-group">
                    <label class="form-label" for="full_name">
                        Full Name <span class="req">*</span>
                    </label>
                    <input id="full_name"
                           name="full_name"
                           type="text"
                           class="form-control @error('full_name') is-invalid @enderror"
                           value="{{ old('full_name') }}"
                           placeholder="Jane Smith"
                           autocomplete="name">
                    @error('full_name')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="form-group">
                    <label class="form-label" for="email">
                        Email Address <span class="req">*</span>
                    </label>
                    <input id="email"
                           name="email"
                           type="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}"
                           placeholder="jane@example.com"
                           autocomplete="email">
                    @error('email')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Phone --}}
                <div class="form-group">
                    <label class="form-label" for="phone">
                        Phone Number <span class="req">*</span>
                    </label>
                    <input id="phone"
                           name="phone"
                           type="tel"
                           class="form-control @error('phone') is-invalid @enderror"
                           value="{{ old('phone') }}"
                           placeholder="+1 555 000 0000"
                           autocomplete="tel">
                    @error('phone')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Cover Letter --}}
                <div class="form-group">
                    <label class="form-label" for="cover_letter">
                        Cover Letter <span style="color:var(--ink-3); font-weight:400;">(optional)</span>
                    </label>
                    <textarea id="cover_letter"
                              name="cover_letter"
                              rows="4"
                              class="form-control @error('cover_letter') is-invalid @enderror"
                              placeholder="Tell us why you're a great fit…">{{ old('cover_letter') }}</textarea>
                    @error('cover_letter')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- CV Upload --}}
                <div class="form-group">
                    <label class="form-label">
                        CV / Resume <span class="req">*</span>
                    </label>
                    <div class="file-drop" id="fileDrop" onclick="document.getElementById('cv').click()">
                        <input id="cv" name="cv" type="file" accept=".pdf"
                               onchange="handleFile(this)">
                        <div id="fileLabel">
                            <div class="file-drop__icon">📄</div>
                            <p class="file-drop__label">Click to upload your CV</p>
                            <p class="file-drop__sub">PDF only · max 2 MB</p>
                        </div>
                    </div>
                    @error('cv')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="submit-btn">
                    Submit Application
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function handleFile(input) {
    if (input.files && input.files[0]) {
        const f    = input.files[0];
        const size = (f.size / 1024 / 1024).toFixed(2);
        document.getElementById('fileLabel').innerHTML = `
            <div class="file-drop__icon">✅</div>
            <p class="file-drop__label">${f.name}</p>
            <p class="file-drop__sub">${size} MB — click to change</p>
        `;
    }
}
</script>
@endsection
