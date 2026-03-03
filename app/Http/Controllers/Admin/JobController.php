<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobListing;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        $jobs = JobListing::withCount('applications')->latest()->get();

        return view('admin.jobs.index', compact('jobs'));
    }

    public function create()
    {
        return view('admin.jobs.create', ['types' => JobListing::TYPES]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        JobListing::create($data);

        return redirect()
            ->route('admin.jobs.index')
            ->with('success', 'Job posting created successfully.');
    }

    public function edit(JobListing $job)
    {
        return view('admin.jobs.edit', ['job' => $job, 'types' => JobListing::TYPES]);
    }

    public function update(Request $request, JobListing $job)
    {
        $data = $this->validated($request);

        $job->update($data);

        return redirect()
            ->route('admin.jobs.index')
            ->with('success', 'Job posting updated successfully.');
    }

    public function destroy(JobListing $job)
    {
        $job->delete();

        return redirect()
            ->route('admin.jobs.index')
            ->with('success', 'Job posting deleted.');
    }

    public function toggleStatus(JobListing $job)
    {
        $job->update(['status' => $job->isActive() ? 'inactive' : 'active']);

        $label = $job->fresh()->isActive() ? 'activated' : 'deactivated';

        return back()->with('success', "Job posting {$label}.");
    }

    // ── Private ──────────────────────────────────────────────────────────────

    private function validated(Request $request): array
    {
        return $request->validate([
            'title'            => ['required', 'string', 'max:255'],
            'location'         => ['required', 'string', 'max:255'],
            'type'             => ['required', 'in:' . implode(',', JobListing::TYPES)],
            'description'      => ['required', 'string', 'min:20'],
            'requirements'     => ['required', 'string', 'min:10'],
            'responsibilities' => ['nullable', 'string'],
            'status'           => ['required', 'in:active,inactive'],
        ]);
    }
}
