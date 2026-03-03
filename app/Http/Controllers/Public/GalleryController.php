<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\GalleryItem;

class GalleryController extends Controller
{
    public function index()
    {
        $photos = GalleryItem::visible()->where('type', 'photo')->orderBy('sort_order')->latest()->get();
        $videos = GalleryItem::visible()->where('type', 'video')->orderBy('sort_order')->latest()->get();

        return view('public.gallery.index', compact('photos', 'videos'));
    }
}
