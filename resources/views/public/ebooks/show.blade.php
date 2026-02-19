<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $ebook->title }} - RenCMS</title>
    <meta name="description" content="{{ Str::limit(strip_tags($ebook->description), 150) }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-black text-gray-100 min-h-screen">

<nav class="border-b border-white/10 bg-black/80 backdrop-blur sticky top-0 z-20">
    <div class="max-w-5xl mx-auto px-6 h-16 flex items-center justify-between">
        <a href="/" class="font-bold text-lg">
            Ren<span class="text-emerald-400">CMS</span>
        </a>
        <a href="{{ route('public.ebooks.index') }}"
           class="text-sm text-emerald-400 hover:underline">
            ← Kembali ke E-book
        </a>
    </div>
</nav>

<main class="max-w-5xl mx-auto px-6 py-12">

    <div class="grid md:grid-cols-2 gap-10">

        {{-- COVER --}}
        <div>
            @if($ebook->cover_url)
                <img src="{{ $ebook->cover_url }}"
                     alt="{{ $ebook->title }}"
                     class="rounded-2xl border border-white/10 shadow-lg w-full">
            @else
                <div class="bg-gray-800 rounded-2xl h-96 flex items-center justify-center text-gray-500">
                    Tidak ada cover
                </div>
            @endif
        </div>

        {{-- DETAIL --}}
        <div>

            <p class="text-emerald-400 text-sm mb-2">
                {{ $ebook->category->name ?? 'Tanpa Kategori' }}
            </p>

            <h1 class="text-3xl font-bold mb-3">
                {{ $ebook->title }}
            </h1>

            <p class="text-gray-400 text-sm mb-6">
                {{ $ebook->author ?? 'Unknown Author' }}
                • {{ optional($ebook->published_at)->format('d M Y') }}
            </p>

            <div class="text-gray-300 leading-relaxed mb-8">
                {!! nl2br(e($ebook->description)) !!}
            </div>

            {{-- PRICE --}}
            @if($ebook->access_type === 'paid')
                <div class="mb-6">
                    <span class="text-xl font-bold text-emerald-400">
                        Rp {{ number_format($ebook->price, 0, ',', '.') }}
                    </span>
                </div>
            @endif

            {{-- DOWNLOAD FORM --}}
            <form method="POST"
                  action="{{ route('public.ebooks.download', $ebook->slug) }}">
                @csrf

                <div class="mb-4">
                    <div class="g-recaptcha"
                         data-sitekey="{{ config('services.recaptcha.site_key') }}">
                    </div>

                    @error('g-recaptcha-response')
                        <p class="mt-2 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <button type="submit"
                        class="w-full py-3 rounded-xl font-semibold transition
                        @if($ebook->access_type === 'paid')
                            bg-emerald-500 text-black hover:bg-emerald-400
                        @else
                            bg-white text-black hover:bg-gray-200
                        @endif">
                    
                    @if($ebook->access_type === 'paid')
                        Beli via WhatsApp
                    @elseif($ebook->access_type === 'login')
                        Download (Login Required)
                    @else
                        Download Gratis
                    @endif
                </button>
            </form>

            <p class="text-xs text-gray-500 mt-4">
                Total Download: {{ $ebook->download_count }}
            </p>

        </div>
    </div>

</main>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>

</body>
</html>
