<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Traits\HasSlug;

class ArticleController extends Controller
{
    use AuthorizesRequests, HasSlug;

    public function index()
    {
        $user = auth()->user();

        if ($user->hasAnyRole(['admin', 'super_admin', 'editor'])) {
            $articles = Article::with(['author', 'category'])
                ->latest()
                ->paginate(10);
        } else {
            $articles = Article::with(['author', 'category'])
                ->where('user_id', $user->id)
                ->latest()
                ->paginate(10);
        }

        return view('articles.index', compact('articles'));
    }

    public function create()
    {
        $this->authorize('create', Article::class);

        $categories = Category::all();

        return view('articles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Article::class);

        // Validasi
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'summary' => 'nullable|string|max:500',
            'content' => 'required|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'cover' => 'nullable|image|max:2048',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images', 'public');
        }

        $data['slug'] = $this->generateUniqueSlug(Article::class, $data['title']);
        $data['user_id'] = auth()->id();

        // Tombol action
        $action = $request->input('action', 'draft');
        $data['status'] = $action === 'submit' ? 'pending' : 'draft';

        Article::create($data);

        return redirect()
            ->route('articles.index')
            ->with('success', 'Article saved.');
    }

    public function show(Article $article)
    {
        $this->authorize('view', $article); // optional, pakai policy

        return view('articles.show', compact('article'));
    }


    public function edit(Article $article)
    {
        $this->authorize('update', $article);

        $categories = Category::all();

        return view('articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article)
    {
        $this->authorize('update', $article);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'summary' => 'nullable|string|max:500',
            'content' => 'required|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'cover' => 'nullable|image|max:2048',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images', 'public');
        }

        if ($article->status !== 'published') {
            $data['slug'] = $this->generateUniqueSlug(Article::class, $data['title'], $article->id);
        }

        $action = $request->input('action', 'draft');
        $data['status'] = $action === 'submit' ? 'pending' : 'draft';

        $article->update($data);

        return redirect()
            ->route('articles.index')
            ->with('success', 'Article updated.');
    }

    public function destroy(Article $article)
    {
        $this->authorize('delete', $article);

        $article->delete();

        return back()->with('success', 'Article deleted.');
    }

    public function approve(Article $article)
    {
        $this->authorize('update', $article);

        // Update status jadi published & set tanggal publish sekarang
        $article->update([
            'status' => 'published',
            'published_at' => now(),
            'rejection_reason' => null, // hapus alasan reject jika sebelumnya ada
        ]);

        return redirect()
            ->route('articles.index')
            ->with('success', 'Article published successfully.');
    }

    public function reject(Request $request, Article $article)
    {
        $this->authorize('update', $article);

        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $article->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        return redirect()
            ->route('articles.index')
            ->with('success', 'Article rejected.');
    }

    // =============================
    // TRASH
    // =============================
    public function trash()
    {
        $user = auth()->user();

        if ($user->hasAnyRole(['admin', 'super_admin', 'editor'])) {
            $articles = Article::onlyTrashed()->with(['author', 'category'])->latest()->paginate(10);
        } else {
            $articles = Article::onlyTrashed()
                ->where('user_id', $user->id)
                ->with(['author', 'category'])
                ->latest()
                ->paginate(10);
        }

        return view('articles.trash', compact('articles'));
    }

    // =============================
    // RESTORE
    // =============================
    public function restore($id)
    {
        $article = Article::onlyTrashed()->findOrFail($id);
        $this->authorize('update', $article); // Pakai policy

        $article->restore();

        return redirect()->route('articles.trash')
            ->with('success', 'Article berhasil direstore.');
    }

    // =============================
    // FORCE DELETE
    // =============================
    public function forceDelete($id)
    {
        $article = Article::onlyTrashed()->findOrFail($id);
        $this->authorize('delete', $article);

        $article->forceDelete();

        return redirect()->route('articles.trash')
            ->with('success', 'Article dihapus permanen.');
    }

}
