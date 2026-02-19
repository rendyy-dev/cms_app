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

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">E-book Terhapus</h1>

        <a href="{{ route('admin.ebooks.index') }}"
           class="px-4 py-2 bg-gray-700 text-white rounded-lg font-semibold hover:bg-gray-600 transition">
            Kembali ke Daftar E-book
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-emerald-500/20 border border-emerald-500/30 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if($ebooks->count())
    <div class="bg-black/40 border border-white/10 rounded-2xl overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead class="bg-white/5 text-gray-400 uppercase tracking-wider text-xs">
                <tr>
                    <th class="px-6 py-4">Judul</th>
                    <th class="px-6 py-4">Author</th>
                    <th class="px-6 py-4">Kategori</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-white/5">
                @foreach($ebooks as $ebook)
                    <tr class="hover:bg-white/5 transition">
                        <td class="px-6 py-4 font-medium">{{ $ebook->title }}</td>
                        <td class="px-6 py-4">{{ $ebook->author }}</td>
                        <td class="px-6 py-4 text-gray-400">{{ $ebook->category?->name ?? '-' }}</td>
                        <td class="px-6 py-4 text-right flex justify-end gap-2">

                            {{-- Restore --}}
                            <button
                                @click="openModal(
                                    '{{ route('admin.ebooks.restore', $ebook->id) }}',
                                    'POST',
                                    'Yakin ingin mengembalikan e-book ini?'
                                )"
                                class="px-3 py-1 bg-emerald-500/20 text-emerald-400 rounded-lg hover:bg-emerald-500/30 transition"
                            >
                                Restore
                            </button>

                            {{-- Force Delete --}}
                            <button
                                @click="openModal(
                                    '{{ route('admin.ebooks.forceDelete', $ebook->id) }}',
                                    'DELETE',
                                    'E-book ini akan dihapus permanen. Lanjutkan?'
                                )"
                                class="px-3 py-1 bg-red-500/20 text-red-400 rounded-lg hover:bg-red-500/30 transition"
                            >
                                Hapus Permanen
                            </button>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $ebooks->links() }}
    </div>

    @else
        <div class="text-center text-gray-500 mt-20">
            Tidak ada e-book di sampah.
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
