<?php

namespace App\Http\Controllers;

use App\Models\Ebook;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EbookController extends Controller
{
    public function index()
    {
        $ebooks = Ebook::latest()->paginate(10);
        return view('ebooks.index', compact('ebooks'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('ebooks.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'cover' => 'nullable|image|max:2048',
            'file' => 'required|mimes:pdf,epub|max:51200',
            'access_type' => 'required|in:free,login',
            'published_at' => 'nullable|date',
            'is_featured' => 'nullable|boolean',
        ]);

        $filePath = $request->file('file')->store('ebooks', 'public');

        $coverPath = null;
        if ($request->hasFile('cover')) {
            $coverPath = $request->file('cover')->store('ebook-covers', 'public');
        }

        Ebook::create([
            'title' => $request->title,
            'author' => $request->author,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'cover_path' => $coverPath,
            'file_path' => $filePath,
            'access_type' => $request->access_type,
            'is_featured' => $request->boolean('is_featured'),
            'published_at' => $request->published_at,
        ]);

        return redirect()
            ->route('admin.ebooks.index')
            ->with('success', 'E-book berhasil ditambahkan.');
    }


    public function show(Ebook $ebook)
    {
        return view('ebooks.show', compact('ebook'));
    }

    public function edit(Ebook $ebook)
    {
        $categories = Category::all();
        return view('ebooks.edit', compact('ebook', 'categories'));
    }

    public function update(Request $request, Ebook $ebook)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'cover' => 'nullable|image|max:2048',
            'file' => 'nullable|mimes:pdf,epub|max:51200',
            'access_type' => 'required|in:free,login',
            'published_at' => 'nullable|date',
            'is_featured' => 'nullable|boolean',
        ]);

        if ($request->hasFile('file')) {
            Storage::disk('public')->delete($ebook->file_path);
            $ebook->file_path = $request->file('file')->store('ebooks', 'public');
        }

        if ($request->hasFile('cover')) {
            if ($ebook->cover_path) {
                Storage::disk('public')->delete($ebook->cover_path);
            }
            $ebook->cover_path = $request->file('cover')->store('ebook-covers', 'public');
        }

        $ebook->update([
            'title' => $request->title,
            'author' => $request->author,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'access_type' => $request->access_type,
            'is_featured' => $request->boolean('is_featured'),
            'published_at' => $request->published_at,
        ]);

        return redirect()
            ->route('admin.ebooks.index')
            ->with('success', 'E-book berhasil diperbarui.');
    }

    public function destroy(Ebook $ebook)
    {
        $ebook->delete(); // soft delete
        return redirect()->route('admin.ebooks.index')->with('success', 'E-book berhasil dihapus.');
    }

    // List e-book yang sudah dihapus (trashed)
    public function trashed()
    {
        $ebooks = Ebook::onlyTrashed()->paginate(10);
        return view('ebooks.trash', compact('ebooks'));
    }

    // Restore e-book yang terhapus
    public function restore($id)
    {
        $ebook = Ebook::onlyTrashed()->findOrFail($id);
        $ebook->restore();
        return redirect()->route('admin.ebooks.trashed')->with('success', 'E-book berhasil dikembalikan.');
    }

    public function forceDelete($id)
    {
        $ebook = Ebook::onlyTrashed()->findOrFail($id);

        // Hapus file di storage
        if ($ebook->file_path) {
            Storage::disk('public')->delete($ebook->file_path);
        }

        $ebook->forceDelete(); // hapus permanen

        return redirect()->route('admin.ebooks.trashed')->with('success', 'E-book berhasil dihapus permanen.');
    }

}
