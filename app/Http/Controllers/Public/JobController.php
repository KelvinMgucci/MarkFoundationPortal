<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\JobListing;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        $jobs = JobListing::active()->latest()->get();

        return view('public.jobs.index', compact('jobs'));
    }

    public function show(JobListing $job)
    {
        abort_if(! $job->isActive(), 404);

        return view('public.jobs.show', compact('job'));
    }

    public function apply(Request $request, JobListing $job)
    {
        abort_if(! $job->isActive(), 404);

        $validated = $request->validate([
            'full_name'    => ['required', 'string', 'max:255'],
            'email'        => ['required', 'email:rfc,dns', 'max:255'],
            'phone'        => ['required', 'string', 'max:30', 'regex:/^[+\d\s\-().]{6,30}$/'],
            'cover_letter' => ['nullable', 'string', 'max:5000'],
            'cv'           => ['required', 'file', 'mimes:pdf', 'max:2048'],
        ], [
            'cv.mimes' => 'Only PDF files are accepted.',
            'cv.max'   => 'CV file must not exceed 2 MB.',
            'phone.regex' => 'Please enter a valid phone number.',
        ]);

        // Store CV in private disk — never publicly accessible
        $cvPath = $request->file('cv')->store('cvs', 'private');

        Application::create([
            'job_id'       => $job->id,
            'full_name'    => $validated['full_name'],
            'email'        => $validated['email'],
            'phone'        => $validated['phone'],
            'cover_letter' => $validated['cover_letter'] ?? null,
            'cv_path'      => $cvPath,
            'status'       => 'new',
        ]);

        return redirect()
            ->route('jobs.show', $job)
            ->with('success', 'Application submitted! We will be in touch soon.');
    }
}
