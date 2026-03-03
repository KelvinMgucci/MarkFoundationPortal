<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $items = GalleryItem::orderBy('sort_order')->latest()->get();
        return view('admin.gallery.index', compact('items'));
    }

    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'type'        => ['required', 'in:photo,video'],
            'photo'       => ['required_if:type,photo', 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'video_url'   => ['required_if:type,video', 'nullable', 'url', 'max:500'],
            'is_visible'  => ['boolean'],
        ]);

        $data = [
            'title'       => $request->title,
            'description' => $request->description,
            'type'        => $request->type,
            'video_url'   => $request->video_url,
            'is_visible'  => $request->boolean('is_visible', true),
            'sort_order'  => GalleryItem::max('sort_order') + 1,
        ];

        if ($request->type === 'photo' && $request->hasFile('photo')) {
            $data['file_path'] = $request->file('photo')->store('gallery', 'public');
        }

        GalleryItem::create($data);

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery item added.');
    }

    public function edit(GalleryItem $gallery)
    {
        return view('admin.gallery.edit', compact('gallery'));
    }

    public function update(Request $request, GalleryItem $gallery)
    {
        $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'photo'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'video_url'   => ['nullable', 'url', 'max:500'],
            'is_visible'  => ['boolean'],
        ]);

        $data = [
            'title'       => $request->title,
            'description' => $request->description,
            'video_url'   => $request->video_url,
            'is_visible'  => $request->boolean('is_visible', true),
        ];

        if ($request->hasFile('photo')) {
            if ($gallery->file_path) Storage::disk('public')->delete($gallery->file_path);
            $data['file_path'] = $request->file('photo')->store('gallery', 'public');
        }

        $gallery->update($data);

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery item updated.');
    }

    public function destroy(GalleryItem $gallery)
    {
        if ($gallery->file_path) Storage::disk('public')->delete($gallery->file_path);
        $gallery->delete();

        return back()->with('success', 'Gallery item deleted.');
    }

    public function toggleVisibility(GalleryItem $gallery)
    {
        $gallery->update(['is_visible' => ! $gallery->is_visible]);
        return back()->with('success', 'Visibility updated.');
    }
}
