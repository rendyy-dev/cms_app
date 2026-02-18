<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Traits\HasSlug;
use App\Models\Photo;


class AlbumController extends Controller
{
    use HasSlug;

    public function index()
    {
        $albums = Album::withCount('photos')
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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover' => 'nullable|image|max:2048',
            'is_featured' => 'nullable|boolean',
            'order' => 'nullable|integer',
        ]);

        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('albums', 'public');
        }

        $data['slug'] = $this->generateUniqueSlug(Album::class, $data['title']);

        Album::create($data);

        return redirect()
            ->route('admin.albums.index')
            ->with('success', 'Album created.');
    }

    public function show(Album $album)
    {
        $album->load('photos');

        return view('albums.show', compact('album'));
    }


    public function edit(Album $album)
    {
        return view('albums.edit', compact('album'));
    }

    public function update(Request $request, Album $album)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover' => 'nullable|image|max:2048',
            'photos.*' => 'nullable|image|max:2048',
            'is_featured' => 'nullable|boolean',
            'order' => 'nullable|integer',
        ]);

        // Update cover
        if ($request->hasFile('cover')) {

            if ($album->cover) {
                Storage::disk('public')->delete($album->cover);
            }

            $data['cover'] = $request->file('cover')->store('albums', 'public');
        }

        // Update slug
        $data['slug'] = $this->generateUniqueSlug(
            Album::class,
            $data['title'],
            $album->id
        );

        $album->update($data);

        // 🔥 MULTIPLE PHOTO UPLOAD
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $index => $photo) {

                $path = $photo->store('albums/photos', 'public');

                $album->photos()->create([
                    'image' => $path,
                    'order' => $index,
                ]);
            }
        }

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
