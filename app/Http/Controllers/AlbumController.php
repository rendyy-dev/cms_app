<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Traits\HasSlug;

class AlbumController extends Controller
{
    use HasSlug;

    public function index()
    {
        $albums = Album::withCount('media')
            ->orderBy('order')
            ->paginate(10);

        return view('albums.index', compact('albums'));
    }

    public function create()
    {
        return view('albums.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'cover'        => 'nullable|image|max:2048',
            'is_featured'  => 'nullable|boolean',
            'order'        => 'nullable|integer',
        ]);

        if ($request->hasFile('cover')) {

            $data['cover'] = $request->file('cover')
                ->store('albums', 'public');
        }

        $data['slug'] = $this->generateUniqueSlug(
            Album::class,
            $data['title']
        );

        $data['is_featured'] = $request->boolean('is_featured');

        Album::create($data);

        return redirect()
            ->route('admin.albums.index')
            ->with('success', 'Album created.');
    }

    public function show(Album $album)
    {
        $album->load('media');

        return view('albums.show', compact('album'));
    }

    public function edit(Album $album)
    {
        return view('albums.edit', compact('album'));
    }

    public function update(Request $request, Album $album)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'cover'        => 'nullable|image|max:2048',
            'is_featured'  => 'nullable|boolean',
            'order'        => 'nullable|integer',
        ]);

        if ($request->hasFile('cover')) {

            if ($album->cover) {
                Storage::disk('public')->delete($album->cover);
            }

            $data['cover'] = $request->file('cover')
                ->store('albums', 'public');
        }

        $data['slug'] = $this->generateUniqueSlug(
            Album::class,
            $data['title'],
            $album->id
        );

        $data['is_featured'] = $request->boolean('is_featured');

        $album->update($data);

        return redirect()
            ->route('admin.albums.edit', $album)
            ->with('success', 'Album updated.');
    }

    public function destroy(Album $album)
    {
        if ($album->cover) {
            Storage::disk('public')->delete($album->cover);
        }

        $album->delete();

        return back()->with('success', 'Album deleted.');
    }
}
