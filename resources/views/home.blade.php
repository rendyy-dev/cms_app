@extends('layouts.app')

@section('content')

<!-- HERO -->
<section id="home" class="relative min-h-screen flex items-center justify-center overflow-hidden">

    <!-- BACKGROUND GLOW -->
    <div class="absolute inset-0 bg-gradient-to-b from-emerald-500/5 to-transparent pointer-events-none"></div>

    <div
        x-data="{ show: false }"
        x-init="setTimeout(() => show = true, 150)"
        :class="show ? 'animate-fade-up' : 'opacity-0 translate-y-6'"
        class="relative z-10 max-w-4xl mx-auto text-center px-6"
    >
        <span class="inline-block mb-6 text-sm text-emerald-400 border border-emerald-400/30 px-4 py-1 rounded-full">
            RenCMS • Aplikasi
        </span>

        <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">
            Selamat Datang,
            <span class="block text-emerald-400">{{ Auth::user()->name }}</span>
        </h1>

        <p class="text-gray-400 mb-10 max-w-2xl mx-auto">
            Kelola seluruh konten digital dalam satu sistem.
            Akses dashboard sesuai role dan mulai produktif sekarang.
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center">

            <a href="{{ auth()->user()->dashboardRoute() }}"
               class="px-6 py-3 bg-emerald-500 text-black font-semibold rounded-lg hover:bg-emerald-400 transition">
                Buka Dashboard
            </a>

            <a href="#overview"
               class="px-6 py-3 border border-white/20 rounded-lg hover:bg-white/10 transition">
                Lihat Ringkasan
            </a>

        </div>
    </div>
</section>



<!-- SYSTEM OVERVIEW -->
<section id="overview" class="py-24 border-t border-white/10">
    <div class="max-w-7xl mx-auto px-6">

        <h2 class="text-3xl font-bold text-center mb-12">
            Ringkasan <span class="text-emerald-400">Sistem</span>
        </h2>

        <div class="grid md:grid-cols-3 gap-6">

            @foreach ([
                ['Manajemen Konten','Kelola artikel, e-book, dan galeri secara terpusat.'],
                ['Role Based System','Dashboard otomatis sesuai peran pengguna.'],
                ['Struktur Modern','Dibangun dengan arsitektur Laravel yang scalable.'],
            ] as [$title,$desc])

                <div
                    x-data="{ show: false }"
                    x-intersect.once="show = true"
                    :class="show ? 'animate-fade-up' : 'opacity-0 translate-y-6'"
                    class="bg-white/5 p-6 rounded-xl border border-white/10 hover:bg-white/10 transition"
                >
                    <h3 class="font-semibold mb-3 text-emerald-400">
                        {{ $title }}
                    </h3>
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

                <a href="" 
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

                <a href="" 
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
            Siap Melanjutkan <span class="text-emerald-400">Aktivitas?</span>
        </h2>

        <p class="text-gray-400 mb-8">
            Gunakan dashboard untuk mengelola sistem secara penuh.
        </p>

        <a href="{{ auth()->user()->dashboardRoute() }}"
           class="px-8 py-4 bg-emerald-500 text-black font-semibold rounded-xl hover:bg-emerald-400 transition">
            Kembali ke Dashboard
        </a>
    </div>
</section>

@endsection
