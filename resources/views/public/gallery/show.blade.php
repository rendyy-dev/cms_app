<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $album->title }} - Gallery</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-black via-gray-900 to-black text-gray-100 min-h-screen">

<main class="max-w-6xl mx-auto px-6 py-14">

    <a href="{{ route('public.gallery.index') }}"
       class="text-sm text-gray-400 hover:text-white transition">
        ← Kembali ke Gallery
    </a>

    <h1 class="text-4xl font-bold mb-10 mt-4">
        {{ $album->title }}
    </h1>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">

        @foreach($media as $item)
            <div class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden p-4">

                @if($item->isImage())
                    <img src="{{ $item->url }}" 
                         class="w-full rounded-lg object-cover">
                @endif

                @if($item->isVideo())
                    <div class="mt-4">
                        {!! $item->embed_html !!}
                    </div>
                @endif

                @if($item->title)
                    <h3 class="mt-4 font-semibold text-emerald-300">
                        {{ $item->title }}
                    </h3>
                @endif

                @if($item->description)
                    <p class="text-sm text-gray-400 mt-2">
                        {{ $item->description }}
                    </p>
                @endif

            </div>
        @endforeach

    </div>

</main>

</body>
</html>
