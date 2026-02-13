<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class PublicArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::with(['author', 'category'])
            ->where('status', 'published')
            ->whereNotNull('published_at');

        // Search by title
        if ($request->filled('q')) {
            $query->where('title', 'like', '%'.$request->q.'%');
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('id', $request->category);
            });
        }

        $articles = $query->latest('published_at')->paginate(9)->withQueryString();
        $categories = Category::all();

        return view('public.articles.index', compact('articles', 'categories'));
    }

    public function show(string $slug)
    {
        $article = Article::with(['author', 'category'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->firstOrFail();

        return view('public.articles.show', compact('article'));
    }
}
