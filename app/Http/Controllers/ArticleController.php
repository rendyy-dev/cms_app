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

        // 🔥 PAKAI TRAIT
        $data['slug'] = $this->generateUniqueSlug(Article::class, $data['title']);

        $data['user_id'] = auth()->id();
        $data['status'] = $request->action === 'submit' ? 'pending' : 'draft';

        Article::create($data);

        return redirect()
            ->route('articles.index')
            ->with('success', 'Article saved.');
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

        if ($article->status !== 'published') {
            $data['slug'] = $this->generateUniqueSlug(
                Article::class,
                $data['title'],
                $article->id
            );
        }

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
}
