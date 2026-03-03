<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Event;
use App\Models\GalleryItem;
use App\Models\JobListing;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_jobs'         => JobListing::count(),
            'active_jobs'        => JobListing::where('status', 'active')->count(),
            'total_applications' => Application::count(),
            'new_applications'   => Application::where('status', 'new')->count(),
            'total_events'       => Event::count(),
            'upcoming_events'    => Event::where('start_date', '>=', now())->count(),
            'gallery_items'      => GalleryItem::where('is_visible', true)->count(),
        ];

        $recentEvents  = Event::orderByDesc('start_date')->take(5)->get();
        $recentGallery = GalleryItem::orderBy('sort_order')->latest()->take(8)->get();
        $recentJobs    = JobListing::withCount('applications')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentEvents', 'recentGallery', 'recentJobs'));
    }
}
