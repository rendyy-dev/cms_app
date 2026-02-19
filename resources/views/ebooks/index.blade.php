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
            <h1 class="text-2xl font-bold">Daftar E-book</h1>
            <p class="text-gray-400 text-sm mt-1">
                Kelola semua e-book di sistem
            </p>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('admin.ebooks.create') }}"
               class="px-4 py-2 bg-emerald-500 text-black rounded-lg font-semibold hover:bg-emerald-400 transition">
                + Tambah E-book
            </a>

            <a href="{{ route('admin.ebooks.trashed') }}"
               class="px-4 py-2 bg-gray-700 text-white rounded-lg font-semibold hover:bg-gray-600 transition">
                Sampah
            </a>
        </div>
    </div>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="mb-4 p-4 bg-emerald-500/20 border border-emerald-500/30 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-4 bg-red-500/20 border border-red-500/30 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    {{-- Table --}}
    <div class="bg-white/5 border border-white/10 rounded-xl overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-white/10 text-gray-400">
                <tr>
                    <th class="px-6 py-4 text-left">Judul</th>
                    <th class="px-6 py-4 text-left">Author</th>
                    <th class="px-6 py-4 text-left">Kategori</th>
                    <th class="px-6 py-4 text-left">Published</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-white/5">
                @forelse($ebooks as $ebook)
                    <tr class="hover:bg-white/5 transition">
                        <td class="px-6 py-4 font-semibold">{{ $ebook->title }}</td>
                        <td class="px-6 py-4">{{ $ebook->author ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-400">{{ $ebook->category?->name ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $ebook->published_at?->format('d M Y') ?? '-' }}</td>
                        <td class="px-6 py-4 text-right flex justify-end gap-2">

                            <a href="{{ route('admin.ebooks.show', $ebook) }}"
                               class="px-3 py-1 bg-white/10 rounded-lg text-sm hover:bg-white/20 transition">
                                View
                            </a>

                            <a href="{{ route('admin.ebooks.edit', $ebook) }}"
                               class="px-3 py-1 bg-white/10 rounded-lg text-sm hover:bg-white/20 transition">
                                Edit
                            </a>

                            <button
                                @click="openModal(
                                    '{{ route('admin.ebooks.destroy', $ebook) }}',
                                    'DELETE',
                                    'Yakin ingin menghapus e-book {{ $ebook->title }}?'
                                )"
                                class="px-3 py-1 bg-red-500/20 text-red-400 rounded-lg hover:bg-red-500/30 transition">
                                Hapus
                            </button>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-6 text-center text-gray-400">
                            Belum ada e-book dibuat.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $ebooks->links() }}
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
