@extends('layouts.super_admin')

@section('content')

<div class="flex items-center justify-between mb-8">
    <h1 class="text-2xl font-bold">Galleries</h1>

    <a href="{{ route('admin.media.create') }}"
       class="px-5 py-2.5 rounded-xl bg-emerald-500 text-black font-semibold hover:bg-emerald-400 transition">
        + Tambah Media
    </a>
</div>

@if(session('success'))
    <div class="mb-6 px-4 py-3 rounded-lg bg-emerald-500/20 text-emerald-400">
        {{ session('success') }}
    </div>
@endif

@if($media->count())

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

    @foreach($media as $item)
        <div class="bg-black border border-white/10 rounded-2xl overflow-hidden group">

            <div class="aspect-square bg-black/40 flex items-center justify-center overflow-hidden">

                @if($item->isImage())
                    <img src="{{ $item->url }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                @elseif($item->isVideo())
                    {!! $item->embed_html !!}
                @endif

            </div>

            <div class="p-4 space-y-2">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-400">
                        {{ $item->album?->title ?? 'No Album' }}
                    </span>

                    @if($item->is_featured)
                        <span class="text-xs px-2 py-1 bg-emerald-500/20 text-emerald-400 rounded-lg">
                            Featured
                        </span>
                    @endif
                </div>

                <h3 class="font-semibold">
                    {{ $item->title ?? 'Untitled' }}
                </h3>

                <div class="flex items-center justify-between pt-3">
                    <a href="{{ route('admin.media.edit', $item) }}"
                       class="text-sm text-emerald-400 hover:underline">
                        Edit
                    </a>

                    <form method="POST"
                          action="{{ route('admin.media.destroy', $item) }}"
                          x-data>

                        @csrf
                        @method('DELETE')

                        <button type="button"
                                @click="$store.confirm.show(
                                    'Hapus Media',
                                    'Yakin ingin menghapus media ini?',
                                    () => $root.submit()
                                )"
                                class="text-sm text-red-400 hover:underline">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>

        </div>
    @endforeach

</div>

<div class="mt-10">
    {{ $media->links() }}
</div>

@else
    <div class="text-center text-gray-500 mt-20">
        Belum ada media.
    </div>
@endif

@endsection
