<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function index()
    {
        $media = Media::with('album')
            ->latest()
            ->paginate(12);

        return view('media.index', compact('media'));
    }

    public function create(Request $request)
    {
        $albums = Album::orderBy('title')->get();
        $selectedAlbum = $request->album;

        return view('media.create', compact('albums', 'selectedAlbum'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'album_id'   => 'nullable|exists:albums,id',
            'file'       => 'nullable|image|max:10240', // foto saja
            'video_url'  => 'nullable|url',
            'title'      => 'nullable|string|max:255',
            'description'=> 'nullable|string',
            'order'      => 'nullable|integer',
            'is_featured'=> 'nullable|boolean',
        ]);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('media','public');
            $type = 'image';
        } elseif ($request->video_url) {
            $path = null;
            $type = 'video';
        } else {
            return back()->withErrors('Harap upload foto atau masukkan link video.');
        }

        Media::create([
            'album_id' => $data['album_id'] ?? null,
            'file_path'=> $path,
            'video_url'=> $data['video_url'] ?? null,
            'type'     => $type,
            'title'    => $data['title'] ?? null,
            'description'=> $data['description'] ?? null,
            'order'   => $data['order'] ?? 0,
            'is_featured'=> $request->boolean('is_featured'),
        ]);

        return redirect()->route('admin.media.index')
                        ->with('success', 'Media berhasil ditambahkan.');
    }

    public function edit(Media $media)
    {
        $albums = Album::orderBy('title')->get();

        return view('media.edit', compact('media', 'albums'));
    }

    public function update(Request $request, Media $media)
    {
        $data = $request->validate([
            'album_id'    => 'nullable|exists:albums,id',
            'file'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'video_url'   => 'nullable|url',
            'title'       => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'order'       => 'nullable|integer',
            'is_featured' => 'nullable|boolean',
        ]);

        // Jika upload gambar baru
        if ($request->hasFile('file')) {

            if ($media->file_path) {
                Storage::disk('public')->delete($media->file_path);
            }

            $media->file_path = $request->file('file')->store('media', 'public');
            $media->video_url = null;
            $media->type = 'image';
        }

        // Jika isi video URL
        if ($request->filled('video_url')) {

            if ($media->file_path) {
                Storage::disk('public')->delete($media->file_path);
                $media->file_path = null;
            }

            $media->video_url = $data['video_url'];
            $media->type = 'video';
        }

        $media->album_id    = $data['album_id'] ?? null;
        $media->title       = $data['title'] ?? null;
        $media->description = $data['description'] ?? null;
        $media->order       = $data['order'] ?? 0;
        $media->is_featured = $request->boolean('is_featured');

        $media->save();

        return redirect()
            ->route('admin.media.index')
            ->with('success', 'Media berhasil diperbarui.');
    }

    public function destroy(Media $media)
    {
        if ($media->file_path) {
            Storage::disk('public')->delete($media->file_path);
        }

        $media->delete();

        return back()->with('success', 'Media berhasil dihapus.');
    }
}
