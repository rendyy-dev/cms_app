<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Article Publik - RenCMS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-black via-gray-900 to-black text-gray-100 min-h-screen">

<nav class="border-b border-white/10 bg-black/70 backdrop-blur sticky top-0 z-20">
    <div class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">
        <a href="/" class="font-bold text-lg tracking-wide">
            Ren<span class="text-emerald-400">CMS</span>
        </a>

        <div class="flex items-center gap-6">
            @php
                $backUrl = auth()->check() ? route('home') : route('landing');
            @endphp
            <a href="{{ $backUrl }}" 
               class="text-sm text-gray-400 hover:text-white transition">
                ← Kembali
            </a>

            <a href="{{ route('public.articles.index') }}" 
               class="text-sm text-emerald-400 hover:text-emerald-300 transition">
                Articles
            </a>
        </div>
    </div>
</nav>

<main class="max-w-6xl mx-auto px-6 py-14">

    <!-- Hero -->
    <div class="mb-12">
        <h1 class="text-4xl md:text-5xl font-bold mb-4 leading-tight">
            Article Publik
        </h1>
        <p class="text-gray-400 text-lg max-w-2xl">
            Kumpulan artikel pilihan yang sudah dipublish oleh author. 
            Baca, pelajari, dan eksplor insight terbaru.
        </p>
    </div>

    <!-- Filter & Search -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
        <form method="GET" action="{{ route('public.articles.index') }}" class="flex flex-1 gap-2">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari artikel..." 
                   class="w-full md:w-72 px-4 py-2 rounded-lg bg-white/5 border border-white/20 text-gray-100 focus:outline-none focus:border-emerald-400 transition"/>
            <button type="submit" class="px-4 py-2 bg-emerald-500 rounded-lg hover:bg-emerald-400 transition">
                Cari
            </button>
        </form>

        <div class="flex gap-2 flex-wrap">
            <a href="{{ route('public.articles.index') }}" 
               class="px-3 py-1 rounded-full {{ request('category') ? 'bg-white/10 text-gray-300' : 'bg-emerald-500 text-black' }} transition">
               Semua Kategori
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('public.articles.index', array_merge(request()->query(), ['category' => $cat->id])) }}" 
                   class="px-3 py-1 rounded-full {{ request('category') == $cat->id ? 'bg-emerald-500 text-black' : 'bg-white/10 text-gray-300' }} transition">
                   {{ $cat->name }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- Grid -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($articles as $article)
            <article class="group bg-white/5 border border-white/10 
                           hover:border-emerald-400/40 
                           rounded-2xl overflow-hidden transition duration-300 
                           hover:-translate-y-1 hover:shadow-xl hover:shadow-emerald-400/10 flex flex-col">

                <!-- Cover -->
                <div class="w-full h-48 bg-gray-800 overflow-hidden">
                    @if($article->cover)
                        <img src="{{ asset('storage/' . $article->cover) }}" 
                             alt="{{ $article->title }}" 
                             class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-500 text-sm">
                            No Image
                        </div>
                    @endif
                </div>

                <div class="p-6 flex flex-col flex-1">
                    <p class="text-xs uppercase tracking-wider text-emerald-300 mb-2">
                        {{ $article->category->name ?? 'Tanpa Kategori' }}
                    </p>

                    <h2 class="text-xl font-semibold mb-3 line-clamp-2 
                               group-hover:text-emerald-300 transition">
                        {{ $article->title }}
                    </h2>

                    <p class="text-sm text-gray-400 mb-4 line-clamp-3 leading-relaxed">
                        {{ $article->summary ?? \Illuminate\Support\Str::limit(strip_tags($article->content), 120) }}
                    </p>

                    <div class="text-xs text-gray-500 mt-auto mb-4">
                        Oleh {{ $article->author->name ?? 'Unknown' }} 
                        • {{ optional($article->published_at)->format('d M Y') }}
                    </div>

                    <a href="{{ route('public.articles.show', $article->slug) }}"
                       class="inline-flex items-center text-sm font-medium text-emerald-400 
                              group-hover:text-emerald-300 transition">
                        Baca selengkapnya
                        <span class="ml-2 transition group-hover:translate-x-1">→</span>
                    </a>
                </div>

            </article>
        @empty
            <div class="col-span-full bg-white/5 border border-white/10 
                        rounded-2xl p-8 text-center text-gray-400">
                Belum ada article yang dipublish.
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-12 flex justify-center">
        <div class="bg-white/5 border border-white/10 rounded-xl px-6 py-4">
            {{ $articles->links() }}
        </div>
    </div>

</main>

<footer class="border-t border-white/10 mt-16">
    <div class="max-w-6xl mx-auto px-6 py-6 text-sm text-gray-500 text-center">
        © {{ date('Y') }} RenCMS. All rights reserved.
    </div>
</footer>

</body>
</html>
