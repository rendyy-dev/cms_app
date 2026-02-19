<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Book Publik - RenCMS</title>
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

            <a href="{{ $backUrl }}" class="text-sm text-gray-400 hover:text-white transition">
                ← Kembali
            </a>

            <a href="{{ route('public.ebooks.index') }}" 
               class="text-sm text-emerald-400 hover:text-emerald-300 transition">
                E-Books
            </a>
        </div>
    </div>
</nav>

<main class="max-w-6xl mx-auto px-6 py-14">

    <div class="mb-12">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">
            E-Book Publik
        </h1>
        <p class="text-gray-400 text-lg max-w-2xl">
            Koleksi e-book pilihan yang bisa kamu baca dan unduh.
        </p>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($ebooks as $ebook)
            <div class="group bg-white/5 border border-white/10 
                        hover:border-emerald-400/40 
                        rounded-2xl overflow-hidden transition duration-300 
                        hover:-translate-y-1 hover:shadow-xl hover:shadow-emerald-400/10 flex flex-col">

                <!-- Cover -->
                <div class="w-full h-56 bg-gray-800 overflow-hidden">
                    @if($ebook->cover_path)
                        <img src="{{ $ebook->cover_url }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-500">
                            No Cover
                        </div>
                    @endif
                </div>

                <div class="p-6 flex flex-col flex-1">

                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs uppercase text-emerald-300">
                            {{ $ebook->access_type === 'free' ? 'Gratis' : 'Login Required' }}
                        </span>

                        <span class="text-xs text-gray-500">
                            {{ $ebook->download_count }} Download
                        </span>
                    </div>

                    <h2 class="text-xl font-semibold mb-3 line-clamp-2 
                               group-hover:text-emerald-300 transition">
                        {{ $ebook->title }}
                    </h2>

                    <p class="text-sm text-gray-400 mb-6 line-clamp-3">
                        {{ \Illuminate\Support\Str::limit(strip_tags($ebook->description), 120) }}
                    </p>

                    <a href="{{ route('public.ebooks.show', $ebook->slug) }}"
                       class="mt-auto inline-flex items-center text-sm font-medium text-emerald-400 
                              group-hover:text-emerald-300 transition">
                        Lihat Detail
                        <span class="ml-2 group-hover:translate-x-1 transition">→</span>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white/5 border border-white/10 
                        rounded-2xl p-8 text-center text-gray-400">
                Belum ada e-book yang dipublish.
            </div>
        @endforelse
    </div>

    <div class="mt-12 flex justify-center">
        <div class="bg-white/5 border border-white/10 rounded-xl px-6 py-4">
            {{ $ebooks->links() }}
        </div>
    </div>

</main>

<footer class="border-t border-white/10 mt-16">
    <div class="max-w-6xl mx-auto px-6 py-6 text-sm text-gray-500 text-center">
        © {{ date('Y') }} RenCMS
    </div>
</footer>

</body>
</html>
