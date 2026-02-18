@extends('layouts.super_admin')

@section('content')

<div class="mb-6">
    <a href="{{ route('admin.albums.index') }}"
       class="inline-flex items-center gap-2 text-sm text-gray-400 hover:text-white transition">
        ← Kembali ke Albums
    </a>
</div>

<div class="flex justify-between items-start mb-8">
    <div>
        <h2 class="text-2xl font-bold">{{ $album->title }}</h2>
        <p class="text-gray-400 mt-2">
            {{ $album->description ?? 'Tidak ada deskripsi.' }}
        </p>
    </div>

    {{-- Tambah Media dengan album terpilih --}}
    <a href="{{ route('admin.media.create', ['album' => $album->id]) }}"
       class="bg-emerald-500 text-black px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-emerald-400 transition">
        + Tambah Media
    </a>
</div>

@if($album->media->count())

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

    @foreach($album->media as $item)

        <div class="bg-black border border-white/10 rounded-2xl overflow-hidden group">

            <div class="aspect-square bg-black/40 flex items-center justify-center overflow-hidden">

                @if($item->type === 'image')
                    <img src="{{ asset('storage/'.$item->file_path) }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                @else
                    <video class="w-full h-full object-cover" muted controls>
                        <source src="{{ asset('storage/'.$item->file_path) }}">
                    </video>
                @endif

            </div>

            <div class="p-4 space-y-2">

                <h3 class="font-semibold">
                    {{ $item->title ?? 'Untitled' }}
                </h3>

                <p class="text-sm text-gray-400">
                    {{ $item->description ?? '-' }}
                </p>

                <div class="flex justify-between items-center pt-3">

                    <a href="{{ route('admin.media.edit', $item) }}"
                       class="text-sm text-emerald-400 hover:underline">
                        Edit
                    </a>

                    <form method="POST"
                          action="{{ route('admin.media.destroy', $item) }}"
                          x-data
                          @submit.prevent="$store.confirm.show(
                            'Hapus Media',
                            'Media ini akan dihapus permanen.',
                            () => $el.submit()
                          )">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="text-sm text-red-400 hover:underline">
                            Hapus
                        </button>
                    </form>

                </div>
            </div>

        </div>

    @endforeach

</div>

@else
    <div class="text-center text-gray-500 mt-20">
        Belum ada media dalam album ini.
    </div>
@endif

@endsection
