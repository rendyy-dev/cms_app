<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $ebook->title }} - RenCMS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-black via-gray-900 to-black text-gray-100 min-h-screen">

<nav class="border-b border-white/10 bg-black/70 backdrop-blur sticky top-0 z-20">
    <div class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">
        <a href="{{ route('public.ebooks.index') }}" 
           class="text-sm text-gray-400 hover:text-white transition">
            ← Kembali ke E-Book
        </a>
    </div>
</nav>

<main class="max-w-5xl mx-auto px-6 py-14">

    <div class="grid md:grid-cols-2 gap-10">

        <!-- Cover -->
        <div class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden">
            @if($ebook->cover_path)
                <img src="{{ $ebook->cover_url }}" class="w-full object-cover">
            @endif
        </div>

        <!-- Info -->
        <div>
            <h1 class="text-4xl font-bold mb-4">
                {{ $ebook->title }}
            </h1>

            <div class="text-sm text-gray-400 mb-4">
                {{ $ebook->download_count }} kali diunduh
            </div>

            <div class="prose prose-invert max-w-none text-gray-300 mb-8">
                {!! nl2br(e($ebook->description)) !!}
            </div>

            <a href="{{ route('public.ebooks.download', $ebook->slug) }}"
               class="inline-block px-6 py-3 bg-emerald-500 text-black font-semibold rounded-xl hover:bg-emerald-400 transition">
                Download Sekarang
            </a>
        </div>

    </div>

</main>

</body>
</html>
