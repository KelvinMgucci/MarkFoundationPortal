<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        $upcoming = Event::published()->where('start_date', '>=', now())->orderBy('start_date')->get();
        $past     = Event::published()->where('start_date', '<', now())->orderByDesc('start_date')->get();

        return view('public.events.index', compact('upcoming', 'past'));
    }

    public function show(Event $event)
    {
        abort_if(! $event->is_published, 404);
        $event->load('media');

        return view('public.events.show', compact('event'));
    }
}
