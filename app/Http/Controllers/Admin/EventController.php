<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::withCount('media')->orderByDesc('start_date')->get();
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateEvent($request);

        $event = Event::create($data);

        $this->handleCoverImage($request, $event);
        $this->handleMediaUploads($request, $event);

        return redirect()->route('admin.events.index')->with('success', 'Event created successfully.');
    }

    public function edit(Event $event)
    {
        $event->load('media');
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $data = $this->validateEvent($request);
        $event->update($data);

        $this->handleCoverImage($request, $event);
        $this->handleMediaUploads($request, $event);

        return redirect()->route('admin.events.index')->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        // Clean up all media files
        foreach ($event->media as $media) {
            if ($media->file_path) Storage::disk('public')->delete($media->file_path);
        }
        if ($event->cover_image_path) Storage::disk('public')->delete($event->cover_image_path);

        $event->delete();

        return back()->with('success', 'Event deleted.');
    }

    public function destroyMedia(EventMedia $media)
    {
        if ($media->file_path) Storage::disk('public')->delete($media->file_path);
        $media->delete();

        return back()->with('success', 'Media removed.');
    }

    public function togglePublished(Event $event)
    {
        $event->update(['is_published' => ! $event->is_published]);
        return back()->with('success', 'Event visibility updated.');
    }

    // ── Private ──────────────────────────────────────────────────────────────

    private function validateEvent(Request $request): array
    {
        return $request->validate([
            'title'        => ['required', 'string', 'max:255'],
            'description'  => ['required', 'string'],
            'location'     => ['nullable', 'string', 'max:255'],
            'start_date'   => ['required', 'date'],
            'end_date'     => ['nullable', 'date', 'after_or_equal:start_date'],
            'rsvp_link'    => ['nullable', 'url', 'max:500'],
            'is_published' => ['boolean'],
        ]);
    }

    private function handleCoverImage(Request $request, Event $event): void
    {
        if ($request->hasFile('cover_image')) {
            $request->validate(['cover_image' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120']]);
            if ($event->cover_image_path) Storage::disk('public')->delete($event->cover_image_path);
            $event->update(['cover_image_path' => $request->file('cover_image')->store('events/covers', 'public')]);
        }
    }

    private function handleMediaUploads(Request $request, Event $event): void
    {
        // Multiple photo uploads
        if ($request->hasFile('photos')) {
            $request->validate(['photos.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120']]);
            foreach ($request->file('photos') as $photo) {
                EventMedia::create([
                    'event_id'   => $event->id,
                    'type'       => 'photo',
                    'file_path'  => $photo->store('events/media', 'public'),
                    'sort_order' => EventMedia::where('event_id', $event->id)->max('sort_order') + 1,
                ]);
            }
        }

        // Multiple video URLs
        if ($request->filled('video_urls')) {
            foreach (array_filter(explode("\n", $request->video_urls)) as $url) {
                $url = trim($url);
                if (filter_var($url, FILTER_VALIDATE_URL)) {
                    EventMedia::create([
                        'event_id'   => $event->id,
                        'type'       => 'video',
                        'video_url'  => $url,
                        'sort_order' => EventMedia::where('event_id', $event->id)->max('sort_order') + 1,
                    ]);
                }
            }
        }
    }
}
