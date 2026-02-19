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
        <div>
            <h1 class="text-2xl font-bold text-emerald-400">Sampah Albums</h1>
            <p class="text-gray-400 text-sm mt-1">
                Album yang telah dihapus (soft delete)
            </p>
        </div>

        <a href="{{ route('admin.albums.index') }}"
           class="px-4 py-2 bg-emerald-500 text-black rounded-lg font-semibold hover:bg-emerald-400 transition">
            Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-emerald-500/20 border border-emerald-500/30 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    {{-- Table --}}
    <div class="bg-white/5 border border-white/10 rounded-xl overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-white/10 text-left">
                <tr>
                    <th class="px-6 py-4">Cover</th>
                    <th class="px-6 py-4">Title</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($albums as $album)
                    <tr class="border-t border-white/10 hover:bg-white/5 transition">
                        <td class="px-6 py-4">
                            @if($album->cover)
                                <img src="{{ asset('storage/'.$album->cover) }}"
                                     class="w-16 h-16 object-cover rounded-lg">
                            @else
                                <div class="w-16 h-16 bg-white/10 rounded-lg"></div>
                            @endif
                        </td>

                        <td class="px-6 py-4 font-medium">
                            {{ $album->title }}
                        </td>

                        <td class="px-6 py-4 text-right space-x-2">

                            {{-- Restore --}}
                            <button
                                @click="openModal(
                                    '{{ route('admin.albums.restore', $album->id) }}',
                                    'POST',
                                    'Yakin ingin merestore album ini?'
                                )"
                                class="px-3 py-1 bg-emerald-500/20 text-emerald-400 rounded-lg hover:bg-emerald-500/30 transition">
                                Restore
                            </button>

                            {{-- Force Delete --}}
                            <button
                                @click="openModal(
                                    '{{ route('admin.albums.forceDelete', $album->id) }}',
                                    'DELETE',
                                    'Album akan dihapus permanen. Tindakan ini tidak bisa dibatalkan.'
                                )"
                                class="px-3 py-1 bg-red-500/20 text-red-400 rounded-lg hover:bg-red-500/30 transition">
                                Hapus Permanen
                            </button>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-6 text-center text-gray-400">
                            Tidak ada album di sampah.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $albums->links() }}
    </div>

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
            <h2 class="text-lg font-semibold text-white mb-4">
                Konfirmasi
            </h2>

            <p class="text-gray-400 text-sm mb-6" x-text="message"></p>

            <form :action="actionUrl" method="POST">
                @csrf

                <template x-if="method === 'DELETE'">
                    <input type="hidden" name="_method" value="DELETE">
                </template>

                <div class="flex justify-end gap-3">
                    <button 
                        type="button"
                        @click="open = false"
                        class="px-4 py-2 text-sm rounded-lg bg-gray-700 hover:bg-gray-600 text-white transition">
                        Batal
                    </button>

                    <button 
                        type="submit"
                        class="px-4 py-2 text-sm rounded-lg bg-emerald-500 hover:bg-emerald-400 text-black font-semibold transition">
                        Ya, Lanjutkan
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
