<?php

namespace App\Http\Controllers;

use App\Models\Album;

class PublicGalleryController extends Controller
{
    public function index()
    {
        $albums = Album::orderBy('order')
            ->latest()
            ->paginate(9);

        return view('public.gallery.index', compact('albums'));
    }

    public function show($slug)
    {
        $album = Album::where('slug', $slug)
            ->firstOrFail();

        $media = $album->media()
            ->orderBy('order')
            ->get();

        return view('public.gallery.show', compact('album', 'media'));
    }
}
