<?php

use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\JobController as PublicJobController;
use App\Http\Controllers\Public\GalleryController;
use App\Http\Controllers\Public\EventController as PublicEventController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\JobController as AdminJobController;
use App\Http\Controllers\Admin\ApplicationController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\StatController;
use App\Http\Middleware\RecruiterAuthenticated;
use App\Models\JobListing;
use Illuminate\Support\Facades\Route;

Route::model('job', JobListing::class);

// ══════════════════════════════════════════════
//  PUBLIC ROUTES
// ══════════════════════════════════════════════
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('jobs')->name('jobs.')->group(function () {
    Route::get('/',             [PublicJobController::class, 'index'])->name('index');
    Route::get('/{job}',        [PublicJobController::class, 'show'])->name('show');
    Route::post('/{job}/apply', [PublicJobController::class, 'apply'])->name('apply');
});

Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');

Route::prefix('events')->name('events.')->group(function () {
    Route::get('/',        [PublicEventController::class, 'index'])->name('index');
    Route::get('/{event}', [PublicEventController::class, 'show'])->name('show');
});

// ══════════════════════════════════════════════
//  ADMIN ROUTES
// ══════════════════════════════════════════════
Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/login',   [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',  [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware(RecruiterAuthenticated::class)->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Jobs
        Route::resource('jobs', AdminJobController::class)->except(['show']);
        Route::post('/jobs/{job}/toggle', [AdminJobController::class, 'toggleStatus'])->name('jobs.toggle');

        // Applications
        Route::get('/jobs/{job}/applications',             [ApplicationController::class, 'index'])->name('applications.index');
        Route::patch('/applications/{application}/status', [ApplicationController::class, 'updateStatus'])->name('applications.status');
        Route::get('/applications/{application}/cv',       [ApplicationController::class, 'downloadCv'])->name('applications.cv');

        // Gallery
        Route::resource('gallery', AdminGalleryController::class)->except(['show']);
        Route::post('/gallery/{gallery}/toggle', [AdminGalleryController::class, 'toggleVisibility'])->name('gallery.toggle');

        // Events
        Route::resource('events', AdminEventController::class)->except(['show']);
        Route::post('/events/{event}/toggle',  [AdminEventController::class, 'togglePublished'])->name('events.toggle');
        Route::delete('/events/media/{media}', [AdminEventController::class, 'destroyMedia'])->name('events.media.destroy');

        // Team
        Route::resource('team', TeamController::class)->except(['show']);

        // Testimonials
        Route::resource('testimonials', TestimonialController::class)->except(['show']);

        // FAQs
        Route::resource('faqs', FaqController::class)->except(['show']);

        // Stats
        Route::resource('stats', StatController::class)->except(['show']);
    });
});
