<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery - RenCMS</title>
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

            <a href="{{ route('public.gallery.index') }}" 
               class="text-sm text-emerald-400 hover:text-emerald-300 transition">
                Gallery
            </a>
        </div>
    </div>
</nav>

<main class="max-w-6xl mx-auto px-6 py-14">

    <h1 class="text-4xl font-bold mb-12">
        Gallery Album
    </h1>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($albums as $album)
            <a href="{{ route('public.gallery.show', $album->slug) }}"
               class="group bg-white/5 border border-white/10 
                      hover:border-emerald-400/40 rounded-2xl overflow-hidden transition duration-300">

                <div class="h-56 bg-gray-800 overflow-hidden">
                    @if($album->cover)
                        <img src="{{ asset('storage/'.$album->cover) }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    @endif
                </div>

                <div class="p-6">
                    <h2 class="text-xl font-semibold group-hover:text-emerald-300 transition">
                        {{ $album->title }}
                    </h2>
                    <p class="text-sm text-gray-400 mt-2 line-clamp-2">
                        {{ $album->description }}
                    </p>
                </div>

            </a>
        @endforeach
    </div>

    <div class="mt-12 flex justify-center">
        {{ $albums->links() }}
    </div>

</main>

</body>
</html>
