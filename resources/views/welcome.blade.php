<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>RenCMS</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-black text-gray-100 antialiased">

<!-- NAVBAR -->
<nav class="fixed top-0 left-0 right-0 z-50 bg-black/80 backdrop-blur border-b border-white/10">
    <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
        <div class="font-bold text-lg">
            Ren<span class="text-emerald-400">CMS</span>
        </div>

        <div class="hidden md:flex gap-6 text-sm text-gray-300 items-center">
            <a href="#home" data-scroll class="hover:text-white">Home</a>
            <a href="#features" data-scroll class="hover:text-white">Fitur</a>
            <a href="#catalog" data-scroll class="hover:text-white">Konten</a>
            <a href="/login" class="hover:text-white">Login</a>
            <a href="/register"
               class="px-4 py-1.5 rounded-lg bg-emerald-500 text-black font-semibold hover:bg-emerald-400">
                Register
            </a>
        </div>
    </div>
</nav>

<!-- HERO -->
<section id="home" class="relative min-h-screen flex items-center justify-center pt-24">
    
    <!-- PARTICLE BACKGROUND -->
    <div class="particles">
        @for ($i = 0; $i < 60; $i++)
            <span
                class="particle"
                style="
                    left: {{ rand(0,100) }}%;
                    animation-duration: {{ rand(8,16) }}s;
                    animation-delay: -{{ rand(0,16) }}s;
                "
            ></span>
        @endfor
    </div>

    <!-- CONTENT -->
    <div
        x-data="{ show: false }"
        x-init="setTimeout(() => show = true, 150)"
        :class="show ? 'animate-fade-up' : 'opacity-0 translate-y-6'"
        class="relative z-10 max-w-3xl mx-auto text-center px-6"
    >
        <span class="inline-block mb-6 text-sm text-emerald-400 border border-emerald-400/30 px-4 py-1 rounded-full">
            CMS Generasi Baru
        </span>

        <h1 class="text-4xl md:text-6xl font-bold mb-6">
            Bangun Konten Digital
            <span class="block text-emerald-400">Lebih Cepat & Rapi</span>
        </h1>

        <p class="text-gray-400 mb-10">
            RenCMS adalah CMS modern untuk kreator dan developer.
            Fokus pada kecepatan dan kesederhanaan.
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="/register"
               class="px-6 py-3 bg-emerald-500 text-black font-semibold rounded-lg hover:bg-emerald-400 transition">
                Mulai Sekarang
            </a>
            <a href="#features" data-scroll
               class="px-6 py-3 border border-white/20 rounded-lg hover:bg-white/10 transition">
                Lihat Fitur
            </a>
        </div>
    </div>
</section>


<!-- FEATURES -->
<section id="features" class="py-24 border-t border-white/10">
    <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-3xl font-bold text-center mb-12">
            Fitur <span class="text-emerald-400">Unggulan</span>
        </h2>

        <div class="grid md:grid-cols-3 gap-6">
            @foreach ([
                ['Performa Cepat','Optimasi untuk web modern.'],
                ['Aman','Keamanan dari awal.'],
                ['Fleksibel','Artikel, e-book, galeri.'],
            ] as [$title,$desc])
                <div
                    x-data="{ show: false }"
                    x-intersect.once="show = true"
                    :class="show ? 'animate-fade-up' : 'opacity-0 translate-y-6'"
                    class="bg-white/5 p-6 rounded-xl border border-white/10 hover:bg-white/10 transition"
                >
                    <h3 class="font-semibold mb-2">{{ $title }}</h3>
                    <p class="text-gray-400 text-sm">{{ $desc }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CATALOG -->
<section id="catalog" class="py-24">
    <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-3xl font-bold text-center mb-12">
            Jenis <span class="text-emerald-400">Konten</span>
        </h2>

        <div class="grid md:grid-cols-3 gap-6">
            @foreach (['E-Book','Artikel','Galeri'] as $item)
                <div
                    x-data="{ show: false }"
                    x-intersect.once="show = true"
                    :class="show ? 'animate-fade-up' : 'opacity-0 translate-y-6'"
                    class="bg-white/5 p-6 rounded-xl border border-white/10 hover:scale-105 transition"
                >
                    <h3 class="font-semibold mb-2 text-emerald-400">{{ $item }}</h3>
                    <p class="text-gray-400 text-sm">Konten profesional.</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-24 border-t border-white/10 text-center">
    <div
        x-data="{ show: false }"
        x-intersect.once="show = true"
        :class="show ? 'animate-fade-up' : 'opacity-0 translate-y-6'"
    >
        <h2 class="text-3xl font-bold mb-6">
            Siap Menggunakan <span class="text-emerald-400">RenCMS?</span>
        </h2>
        <p class="text-gray-400 mb-8">
            Gratis digunakan. Tanpa kartu kredit.
        </p>
        <a href="/register"
           class="px-8 py-4 bg-emerald-500 text-black font-semibold rounded-xl hover:bg-emerald-400 transition">
            Buat Akun Gratis
        </a>
    </div>
</section>

<footer class="border-t border-white/10 py-10 text-center text-sm text-gray-500">
    © {{ date('Y') }} RenCMS. Seluruh hak cipta dilindungi.
</footer>

</body>
</html>
