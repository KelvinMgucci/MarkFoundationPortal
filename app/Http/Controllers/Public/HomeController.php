<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\GalleryItem;
use App\Models\JobListing;

class HomeController extends Controller
{
    public function index()
    {
        $featuredJobs   = JobListing::active()->latest()->take(3)->get();

        $upcomingEvents = Event::published()
                            ->where('start_date', '>=', now())
                            ->orderBy('start_date')
                            ->take(3)
                            ->get();

        $galleryItems   = GalleryItem::visible()
                            ->orderBy('sort_order')
                            ->latest()
                            ->take(8)
                            ->get();

        return view('public.home', compact('featuredJobs', 'upcomingEvents', 'galleryItems'));
    }
}
