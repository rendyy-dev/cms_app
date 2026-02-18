<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    public function create(Album $album)
    {
        return view('albums.createPhoto', compact('album'));
    }

    public function store(Request $request, Album $album)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
            'caption' => 'nullable|string',
            'order' => 'nullable|integer'
        ]);

        $path = $request->file('image')->store('photos', 'public');

        Photo::create([
            'album_id' => $album->id,
            'image' => $path,
            'caption' => $request->caption,
            'order' => $request->order ?? 0,
        ]);

        return redirect()
            ->route('admin.albums.show', $album)
            ->with('success', 'Foto berhasil ditambahkan');
    }

    public function destroy(Photo $photo)
    {
        Storage::disk('public')->delete($photo->image);
        $photo->delete();

        return back()->with('success', 'Foto berhasil dihapus');
    }
}
