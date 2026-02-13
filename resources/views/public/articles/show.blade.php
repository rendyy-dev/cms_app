<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $article->meta_title ?? $article->title }} - RenCMS</title>
    <meta name="description" content="{{ $article->meta_description ?? $article->summary }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-black text-gray-100 min-h-screen">
<nav class="border-b border-white/10 bg-black/80 backdrop-blur sticky top-0 z-20">
    <div class="max-w-4xl mx-auto px-6 h-16 flex items-center justify-between">
        <a href="/" class="font-bold text-lg">Ren<span class="text-emerald-400">CMS</span></a>
        <a href="{{ route('public.articles.index') }}" class="text-sm text-emerald-400">← Kembali ke Articles</a>
    </div>
</nav>

<main class="max-w-4xl mx-auto px-6 py-10">
    <p class="text-emerald-300 text-sm mb-2">{{ $article->category->name ?? 'Tanpa Kategori' }}</p>
    <h1 class="text-3xl font-bold mb-3">{{ $article->title }}</h1>
    <p class="text-sm text-gray-500 mb-8">
        Oleh {{ $article->author->name ?? 'Unknown' }} • {{ optional($article->published_at)->format('d M Y H:i') }}
    </p>

    @if($article->cover)
        <img src="{{ asset('storage/' . $article->cover) }}" alt="{{ $article->title }}" class="rounded-xl border border-white/10 mb-8 w-full object-cover max-h-[420px]">
    @endif

    <article class="prose prose-invert max-w-none prose-headings:text-white prose-p:text-gray-200">
        {!! $article->content !!}
    </article>
</main>
</body>
</html>
