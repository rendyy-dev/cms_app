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
            <h1 class="text-2xl font-bold">Categories</h1>
            <p class="text-gray-400 text-sm mt-1">
                Kelola semua kategori artikel di sistem
            </p>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('admin.categories.create') }}"
               class="px-4 py-2 bg-emerald-500 text-black rounded-lg font-semibold hover:bg-emerald-400 transition">
                + Tambah Category
            </a>

            <a href="{{ route('admin.categories.trash') }}"
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
                    <th class="px-6 py-4 text-left">Nama</th>
                    <th class="px-6 py-4 text-left">Deskripsi</th>
                    <th class="px-6 py-4 text-left">Slug</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-white/5">
                @forelse($categories as $category)
                    <tr class="hover:bg-white/5 transition">
                        <td class="px-6 py-4 font-semibold">{{ $category->name }}</td>
                        <td class="px-6 py-4 text-gray-400 max-w-xs truncate">
                            {{ $category->description ?? '-' }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs bg-emerald-500/20 text-emerald-400 rounded-full">
                                {{ $category->slug }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right flex justify-end gap-2">

                            <a href="{{ route('admin.categories.edit', $category) }}"
                               class="px-3 py-1 bg-white/10 rounded-lg text-sm hover:bg-white/20 transition">
                                Edit
                            </a>

                            <button
                                @click="openModal(
                                    '{{ route('admin.categories.destroy', $category) }}',
                                    'DELETE',
                                    'Yakin ingin menghapus category {{ $category->name }}?'
                                )"
                                class="px-3 py-1 bg-red-500/20 text-red-400 rounded-lg hover:bg-red-500/30 transition">
                                Hapus
                            </button>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-6 text-center text-gray-400">
                            Belum ada category dibuat.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $categories->links() }}
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
