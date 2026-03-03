<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\JobListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    public function index(JobListing $job)
    {
        $applications = $job->applications()->latest()->get();

        return view('admin.applications.index', compact('job', 'applications'));
    }

    public function updateStatus(Request $request, Application $application)
    {
        $request->validate([
            'status' => ['required', 'in:' . implode(',', Application::STATUSES)],
        ]);

        $application->update(['status' => $request->status]);

        return back()->with('success', 'Status updated to "' . Application::STATUS_LABELS[$request->status] . '".');
    }

    /**
     * Stream the CV file to an authenticated recruiter.
     * CVs are stored on the private disk and never directly web-accessible.
     */
    public function downloadCv(Application $application)
    {
        $disk = Storage::disk('private');

        abort_unless($disk->exists($application->cv_path), 404, 'CV file not found.');

        $filename = 'CV_' . \Str::slug($application->full_name) . '_' . $application->id . '.pdf';

        return $disk->download($application->cv_path, $filename, [
            'Content-Type' => 'application/pdf',
        ]);
    }
}
