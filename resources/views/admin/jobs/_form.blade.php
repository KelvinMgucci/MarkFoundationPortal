{{--
    Shared job form.
    Variables expected:
      $types  — array of job type strings (from Job::TYPES)
      $job    — Job model (on edit); undefined on create
--}}

<div class="card">
    <div class="card-body">

        <div class="form-row">
            {{-- Title --}}
            <div class="form-group">
                <label class="form-label" for="title">
                    Job Title <span class="req">*</span>
                </label>
                <input id="title"
                       name="title"
                       type="text"
                       class="form-control @error('title') is-invalid @enderror"
                       value="{{ old('title', $job->title ?? '') }}"
                       placeholder="e.g. Senior Software Engineer"
                       autofocus>
                @error('title')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Location --}}
            <div class="form-group">
                <label class="form-label" for="location">
                    Location <span class="req">*</span>
                </label>
                <input id="location"
                       name="location"
                       type="text"
                       class="form-control @error('location') is-invalid @enderror"
                       value="{{ old('location', $job->location ?? '') }}"
                       placeholder="e.g. New York, NY or Remote">
                @error('location')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="form-row">
            {{-- Job type --}}
            <div class="form-group">
                <label class="form-label" for="type">
                    Job Type <span class="req">*</span>
                </label>
                <select id="type"
                        name="type"
                        class="form-control @error('type') is-invalid @enderror">
                    <option value="" disabled {{ old('type', $job->type ?? '') === '' ? 'selected' : '' }}>
                        Select type…
                    </option>
                    @foreach($types as $t)
                        <option value="{{ $t }}"
                            {{ old('type', $job->type ?? '') === $t ? 'selected' : '' }}>
                            {{ $t }}
                        </option>
                    @endforeach
                </select>
                @error('type')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Status --}}
            <div class="form-group">
                <label class="form-label" for="status">
                    Status <span class="req">*</span>
                </label>
                <select id="status"
                        name="status"
                        class="form-control @error('status') is-invalid @enderror">
                    <option value="active"
                        {{ old('status', $job->status ?? 'active') === 'active' ? 'selected' : '' }}>
                        Active — visible to applicants
                    </option>
                    <option value="inactive"
                        {{ old('status', $job->status ?? 'active') === 'inactive' ? 'selected' : '' }}>
                        Inactive — hidden from public
                    </option>
                </select>
                @error('status')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Description --}}
        <div class="form-group">
            <label class="form-label" for="description">
                Job Description <span class="req">*</span>
            </label>
            <textarea id="description"
                      name="description"
                      rows="7"
                      class="form-control @error('description') is-invalid @enderror"
                      placeholder="Provide a compelling overview of the role, team, and what the candidate will be doing…">{{ old('description', $job->description ?? '') }}</textarea>
            @error('description')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Responsibilities --}}
        <div class="form-group">
            <label class="form-label" for="responsibilities">
                Responsibilities
                <span style="color:var(--ink-3); font-weight:400;">(optional)</span>
            </label>
            <textarea id="responsibilities"
                      name="responsibilities"
                      rows="5"
                      class="form-control @error('responsibilities') is-invalid @enderror"
                      placeholder="List the main responsibilities, one per line…">{{ old('responsibilities', $job->responsibilities ?? '') }}</textarea>
            @error('responsibilities')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Requirements --}}
        <div class="form-group" style="margin-bottom:0;">
            <label class="form-label" for="requirements">
                Requirements <span class="req">*</span>
            </label>
            <textarea id="requirements"
                      name="requirements"
                      rows="5"
                      class="form-control @error('requirements') is-invalid @enderror"
                      placeholder="List skills, qualifications, and experience required…">{{ old('requirements', $job->requirements ?? '') }}</textarea>
            @error('requirements')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

    </div>

    <div style="padding:1.125rem 1.5rem; border-top:1px solid var(--border); display:flex; gap:.75rem; justify-content:flex-end;">
        <a href="{{ route('admin.jobs.index') }}" class="btn btn-ghost">Cancel</a>
        <button type="submit" class="btn btn-amber">
            {{ isset($job) ? 'Save Changes' : 'Create Job Posting' }}
        </button>
    </div>
</div>
