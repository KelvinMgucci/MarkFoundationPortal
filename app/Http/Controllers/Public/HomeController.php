<?php
namespace App\Http\Controllers\Public;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\GalleryItem;
use App\Models\JobListing;
use App\Models\TeamMember;
use App\Models\Testimonial;
use App\Models\Faq;
use App\Models\Stat;

class HomeController extends Controller {
    public function index() {
        $upcomingEvents = Event::where('is_published', true)->where('start_date', '>=', now())->orderBy('start_date')->take(3)->get();
        $galleryItems   = GalleryItem::where('is_visible', true)->orderBy('sort_order')->latest()->take(8)->get();
        $featuredJobs   = JobListing::where('status','active')->latest()->take(3)->get();
        $teamMembers    = TeamMember::where('is_visible', true)->orderBy('sort_order')->get();
        $testimonials   = Testimonial::where('is_visible', true)->orderBy('sort_order')->get();
        $faqs           = Faq::where('is_visible', true)->orderBy('sort_order')->get();
        $stats          = Stat::where('is_visible', true)->orderBy('sort_order')->get();
        return view('public.home', compact('upcomingEvents','galleryItems','featuredJobs','teamMembers','testimonials','faqs','stats'));
    }
}
