<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ArticleController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $user = auth()->user();

        if ($user->hasAnyRole(['admin', 'super_admin', 'editor'])) {
            $articles = Article::with(['author', 'category'])
                ->latest()
                ->get();
        } else {
            $articles = Article::with(['author', 'category'])
                ->where('user_id', $user->id)
                ->latest()
                ->get();
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

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'summary' => 'nullable|string',
            'content' => 'required|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'cover' => 'nullable|image|max:2048',
            'image' => 'nullable|image|max:2048',
        ]);

        // Upload cover
        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        // Upload image (optional)
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images', 'public');
        }

        // Generate unique slug
        $data['slug'] = $this->generateUniqueSlug($data['title']);

        $data['user_id'] = auth()->id();

        $data['status'] = $request->action === 'submit'
            ? 'pending'
            : 'draft';


        Article::create($data);

        return redirect()
            ->route('articles.index')
            ->with('success', 'Article saved as draft.');
    }

    public function show(Article $article)
    {
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
            'summary' => 'nullable|string',
            'content' => 'required|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'cover' => 'nullable|image|max:2048',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images', 'public');
        }

        // Slug hanya berubah kalau belum published
        if ($article->status !== 'published') {
            $data['slug'] = $this->generateUniqueSlug($data['title'], $article->id);
        }

        // Tentukan status berdasarkan tombol
        if ($request->action === 'submit') {
            $data['status'] = 'pending';
        } elseif ($request->action === 'draft') {
            $data['status'] = 'draft';
        }


        $article->update($data);

        return redirect()
            ->route('articles.index')
            ->with('success', 'Article updated.');
    }

    public function submit(Article $article)
    {
        $this->authorize('submit', $article);

        $article->update([
            'status' => 'pending',
        ]);

        return back()->with('success', 'Article submitted for review.');
    }

    public function approve(Article $article)
    {
        $this->authorize('approve', $article);

        $article->update([
            'status' => 'published',
            'published_at' => now(),
        ]);

        return back()->with('success', 'Article approved and published.');
    }

    public function reject(Request $request, Article $article)
    {
        $this->authorize('reject', $article);

        $request->validate([
            'rejection_reason' => 'required|string'
        ]);

        $article->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        return back()->with('success', 'Article rejected.');
    }

    public function destroy(Article $article)
    {
        $this->authorize('delete', $article);

        $article->delete();

        return back()->with('success', 'Article deleted.');
    }

    /**
     * Generate Unique Slug
     */
    private function generateUniqueSlug($title, $ignoreId = null)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        while (
            Article::where('slug', $slug)
                ->when($ignoreId, function ($query) use ($ignoreId) {
                    $query->where('id', '!=', $ignoreId);
                })
                ->exists()
        ) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }
}
