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
        <p class="text-gray-400 mt-2">{{ $album->description }}</p>
    </div>

    <a href="{{ route('admin.photos.create', $album) }}"
       class="bg-emerald-500 text-black px-4 py-2 rounded-lg text-sm hover:bg-emerald-400 transition">
        + Tambah Foto
    </a>
</div>

<div class="grid grid-cols-4 gap-6">
    @foreach($album->photos as $photo)
        <div class="bg-black/40 border border-white/10 rounded-xl p-4">
            <img src="{{ asset('storage/'.$photo->image) }}"
                 class="rounded-lg mb-3">

            <p class="text-sm text-gray-400 mb-3">
                {{ $photo->caption }}
            </p>

            <form method="POST"
                  action="{{ route('admin.photos.delete', $photo) }}"
                  x-data
                  @submit.prevent="$store.confirm.show(
                    'Hapus Foto',
                    'Foto akan dihapus permanen.',
                    () => $el.submit()
                  )">
                @csrf
                @method('DELETE')

                <button type="submit"
                        class="w-full bg-red-500 text-black py-1 rounded-lg text-sm hover:bg-red-400">
                    Hapus
                </button>
            </form>
        </div>
    @endforeach
</div>

@endsection
