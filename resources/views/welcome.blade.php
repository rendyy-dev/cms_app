<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RenCMS</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-black text-gray-100 antialiased scroll-smooth">

<!-- NAVBAR -->
<nav class="fixed top-0 left-0 right-0 z-50 bg-black/80 backdrop-blur border-b border-white/10">
    <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">

        <div class="font-bold text-lg tracking-wide">
            Ren<span class="text-emerald-400">CMS</span>
        </div>

        <div class="hidden md:flex gap-6 text-sm text-gray-300 items-center">

            <a href="#home" class="hover:text-white transition">Home</a>
            <a href="#features" class="hover:text-white transition">Fitur</a>
            <a href="#catalog" class="hover:text-white transition">Konten</a>

            @guest
                <a href="{{ route('login') }}" class="hover:text-white transition">
                    Login
                </a>

                <a href="{{ route('register') }}"
                   class="px-4 py-1.5 rounded-lg bg-emerald-500 text-black font-semibold hover:bg-emerald-400 transition">
                    Register
                </a>
            @endguest

            @auth
                <a href="{{ route('home') }}"
                   class="px-4 py-1.5 rounded-lg bg-emerald-500 text-black font-semibold hover:bg-emerald-400 transition">
                    Masuk Aplikasi
                </a>
            @endauth

        </div>
    </div>
</nav>


<!-- HERO -->
<section id="home" class="relative min-h-screen flex items-center justify-center pt-24 overflow-hidden">

    <!-- BACKGROUND GLOW -->
    <div class="absolute inset-0 bg-gradient-to-b from-emerald-500/5 to-transparent pointer-events-none"></div>

    <!-- PARTICLES -->
    <div class="particles absolute inset-0">
        @for ($i = 0; $i < 50; $i++)
            <span
                class="particle"
                style="
                    left: {{ rand(0,100) }}%;
                    animation-duration: {{ rand(10,18) }}s;
                    animation-delay: -{{ rand(0,18) }}s;
                "
            ></span>
        @endfor
    </div>

    <!-- CONTENT -->
    <div
        x-data="{ show: false }"
        x-init="setTimeout(() => show = true, 150)"
        :class="show ? 'animate-fade-up' : 'opacity-0 translate-y-6'"
        class="relative z-10 max-w-4xl mx-auto text-center px-6"
    >
        <span class="inline-block mb-6 text-sm text-emerald-400 border border-emerald-400/30 px-4 py-1 rounded-full">
            CMS Modern & Minimalis
        </span>

        <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">
            Bangun & Kelola Konten
            <span class="block text-emerald-400">Tanpa Ribet</span>
        </h1>

        <p class="text-gray-400 mb-10 max-w-2xl mx-auto">
            RenCMS membantu kamu mengelola artikel, e-book,
            dan galeri dalam satu sistem yang cepat,
            aman, dan terstruktur.
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center">

            @guest
                <a href="{{ route('register') }}"
                   class="px-6 py-3 bg-emerald-500 text-black font-semibold rounded-lg hover:bg-emerald-400 transition">
                    Mulai Sekarang
                </a>
            @endguest

            @auth
                <a href="{{ route('home') }}"
                   class="px-6 py-3 bg-emerald-500 text-black font-semibold rounded-lg hover:bg-emerald-400 transition">
                    Buka Aplikasi
                </a>
            @endauth

            <a href="#features"
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
            Fitur <span class="text-emerald-400">Utama</span>
        </h2>

        <div class="grid md:grid-cols-3 gap-6">

            @foreach ([
                ['Manajemen Konten','Kelola artikel, e-book, dan galeri dalam satu sistem terpusat.'],
                ['Role Management','Sistem role fleksibel: super admin, admin, editor, author.'],
                ['Keamanan Terstruktur','Akses dikontrol melalui middleware dan role-based system.'],
            ] as [$title,$desc])

                <div
                    x-data="{ show: false }"
                    x-intersect.once="show = true"
                    :class="show ? 'animate-fade-up' : 'opacity-0 translate-y-6'"
                    class="bg-white/5 p-6 rounded-xl border border-white/10 hover:bg-white/10 transition"
                >
                    <h3 class="font-semibold mb-3 text-emerald-400">{{ $title }}</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        {{ $desc }}
                    </p>
                </div>

            @endforeach

        </div>
    </div>
</section>

<!-- CONTENT TYPES -->
<section id="catalog" class="py-24 border-t border-white/10">
    <div class="max-w-7xl mx-auto px-6">

        <h2 class="text-3xl font-bold text-center mb-12">
            Jenis <span class="text-emerald-400">Konten</span>
        </h2>

        <div class="grid md:grid-cols-3 gap-6">

            <!-- E-Book Card -->
            <div
                x-data="{ show: false }"
                x-intersect.once="show = true"
                :class="show ? 'animate-fade-up' : 'opacity-0 translate-y-6'"
                class="group bg-white/5 p-6 rounded-xl border border-white/10 hover:scale-105 hover:bg-white/10 transition flex flex-col justify-between"
            >
                <div>
                    <h3 class="font-semibold mb-2 text-emerald-400">E-Book</h3>
                    <p class="text-gray-400 text-sm mb-6">
                        Distribusi konten digital profesional.
                    </p>
                </div>

                <a href="{{ route('public.ebooks.index') }}" 
                   class="inline-flex items-center text-sm text-gray-300 group-hover:text-emerald-400 transition">
                    Selengkapnya
                    <span class="ml-2 transition group-hover:translate-x-1">→</span>
                </a>
            </div>

            <!-- Artikel Card -->
            <div
                x-data="{ show: false }"
                x-intersect.once="show = true"
                :class="show ? 'animate-fade-up' : 'opacity-0 translate-y-6'"
                class="group bg-white/5 p-6 rounded-xl border border-white/10 hover:scale-105 hover:bg-white/10 transition flex flex-col justify-between"
            >
                <div>
                    <h3 class="font-semibold mb-2 text-emerald-400">Artikel</h3>
                    <p class="text-gray-400 text-sm mb-6">
                        Publikasi tulisan terstruktur.
                    </p>
                </div>

                <a href="{{ route('public.articles.index') }}" 
                   class="inline-flex items-center text-sm text-gray-300 group-hover:text-emerald-400 transition">
                    Selengkapnya
                    <span class="ml-2 transition group-hover:translate-x-1">→</span>
                </a>
            </div>

            <!-- Galeri Card -->
            <div
                x-data="{ show: false }"
                x-intersect.once="show = true"
                :class="show ? 'animate-fade-up' : 'opacity-0 translate-y-6'"
                class="group bg-white/5 p-6 rounded-xl border border-white/10 hover:scale-105 hover:bg-white/10 transition flex flex-col justify-between"
            >
                <div>
                    <h3 class="font-semibold mb-2 text-emerald-400">Galeri</h3>
                    <p class="text-gray-400 text-sm mb-6">
                        Manajemen media visual.
                    </p>
                </div>

                <a href="{{ route('public.gallery.index') }}" 
                   class="inline-flex items-center text-sm text-gray-300 group-hover:text-emerald-400 transition">
                    Selengkapnya
                    <span class="ml-2 transition group-hover:translate-x-1">→</span>
                </a>
            </div>

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
            Sistem ringan. Struktur jelas. Siap dikembangkan.
        </p>

        @guest
            <a href="{{ route('register') }}"
               class="px-8 py-4 bg-emerald-500 text-black font-semibold rounded-xl hover:bg-emerald-400 transition">
                Buat Akun Gratis
            </a>
        @else
            <a href="{{ route('home') }}"
               class="px-8 py-4 bg-emerald-500 text-black font-semibold rounded-xl hover:bg-emerald-400 transition">
                Masuk ke Aplikasi
            </a>
        @endguest

    </div>
</section>


<footer class="border-t border-white/10 py-10 text-center text-sm text-gray-500">
    © {{ date('Y') }} RenCMS. Seluruh hak cipta dilindungi.
</footer>

</body>
</html>
