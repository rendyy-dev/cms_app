@extends('layouts.super_admin')

@section('content')
<div 
    x-data="{
        open:false,
        actionUrl:'',
        method:'POST',
        message:'',
        openModal(url, methodType, msg) {
            this.actionUrl = url
            this.method = methodType
            this.message = msg
            this.open = true
        }
    }"
    class="max-w-7xl mx-auto"
>

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Media Trash</h1>

        <a href="{{ route('admin.media.index') }}"
           class="px-4 py-2 bg-gray-700 text-white rounded-lg font-semibold hover:bg-gray-600 transition">
            Kembali ke Media
        </a>
    </div>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="mb-4 p-4 bg-emerald-500/20 border border-emerald-500/30 rounded-lg">
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

                        {{-- Restore --}}
                        <button
                            @click="openModal(
                                '{{ route('admin.media.restore', $item->id) }}',
                                'POST',
                                'Yakin ingin mengembalikan media ini?'
                            )"
                            class="text-sm text-emerald-400 hover:underline"
                        >
                            Restore
                        </button>

                        {{-- Force Delete --}}
                        <button
                            @click="openModal(
                                '{{ route('admin.media.forceDelete', $item->id) }}',
                                'DELETE',
                                'Media ini akan dihapus permanen. Lanjutkan?'
                            )"
                            class="text-sm text-red-400 hover:underline"
                        >
                            Hapus Permanen
                        </button>

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
            Tidak ada media di sampah.
        </div>
    @endif

    {{-- Modal --}}
    <div 
        x-show="open"
        x-transition
        class="fixed inset-0 flex items-center justify-center bg-black/70 backdrop-blur-sm z-50"
    >
        <div 
            @click.away="open = false"
            class="bg-gray-900 border border-white/10 rounded-xl w-full max-w-md p-6"
        >
            <h2 class="text-lg font-semibold text-white mb-4">Konfirmasi</h2>
            <p class="text-gray-400 text-sm mb-6" x-text="message"></p>

            <form :action="actionUrl" method="POST">
                @csrf
                <template x-if="method === 'DELETE'">
                    <input type="hidden" name="_method" value="DELETE">
                </template>

                <div class="flex justify-end gap-3">
                    <button type="button"
                            @click="open = false"
                            class="px-4 py-2 text-sm rounded-lg bg-gray-700 hover:bg-gray-600 text-white transition">
                        Batal
                    </button>
                    <button type="submit"
                            class="px-4 py-2 text-sm rounded-lg bg-emerald-500 hover:bg-emerald-400 text-black font-semibold transition">
                        Ya, Lanjutkan
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
