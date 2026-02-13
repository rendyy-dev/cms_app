@extends('layouts.app')

@section('content')

<!-- HERO -->
<section class="relative min-h-screen flex items-center justify-center pt-24">
    <div
        x-data="{ show: false }"
        x-init="setTimeout(() => show = true, 150)"
        :class="show ? 'animate-fade-up' : 'opacity-0 translate-y-6'"
        class="relative z-10 max-w-3xl mx-auto text-center px-6"
    >
        <span class="inline-block mb-6 text-sm text-emerald-400 border border-emerald-400/30 px-4 py-1 rounded-full">
            Dashboard CMS
        </span>

        <h1 class="text-4xl md:text-6xl font-bold mb-6">
            Selamat Datang, <span class="text-emerald-400">{{ Auth::user()->name }}</span>
        </h1>

        <p class="text-gray-400 mb-10">
            Kelola konten digitalmu dengan cepat dan rapi.
        </p>
    </div>
</section>

<!-- FEATURES / QUICK LINKS -->
<section class="py-24 border-t border-white/10">
    <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-3xl font-bold text-center mb-12">
            Fitur <span class="text-emerald-400">Dashboard</span>
        </h2>

        <div class="grid md:grid-cols-3 gap-6">
            @foreach ([
                ['Artikel', 'Buat & kelola artikel.'],
                ['E-Book', 'Tambahkan e-book baru.'],
                ['Galeri', 'Kelola galeri gambar.'],
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

<!-- CTA -->
<section class="py-24 border-t border-white/10 text-center">
    <div
        x-data="{ show: false }"
        x-intersect.once="show = true"
        :class="show ? 'animate-fade-up' : 'opacity-0 translate-y-6'"
    >
        <h2 class="text-3xl font-bold mb-6">
            Siap <span class="text-emerald-400">Membuat Konten?</span>
        </h2>
        <p class="text-gray-400 mb-8">
            Klik salah satu fitur di atas untuk mulai membuat kontenmu.
        </p>
        <a href="{{ route('dashboard') }}"
           class="px-8 py-4 bg-emerald-500 text-black font-semibold rounded-xl hover:bg-emerald-400 transition">
            Mulai Sekarang
        </a>
    </div>
</section>

@endsection
