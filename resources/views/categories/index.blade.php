@extends('layouts.super_admin')

@section('content')

<div class="flex items-center justify-between mb-8">
    <div>
        <h2 class="text-3xl font-bold tracking-tight">Categories</h2>
        <p class="text-gray-400 text-sm mt-1">
            Kelola semua kategori artikel di sistem
        </p>
    </div>

    <a href="{{ route('admin.categories.create') }}"
       class="px-4 py-2 rounded-lg bg-emerald-500 text-black font-semibold hover:bg-emerald-400 transition">
        + Tambah Category
    </a>
</div>

@if(session('success'))
    <div class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400">
        {{ session('success') }}
    </div>
@endif

<div class="bg-gradient-to-br from-white/5 to-white/0 
            border border-white/10 
            rounded-2xl shadow-2xl backdrop-blur-xl overflow-hidden">

    <table class="w-full text-sm">
        <thead class="bg-white/5 border-b border-white/10 text-gray-300 uppercase tracking-wider text-xs">
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
                    <td class="px-6 py-4 font-semibold">
                        {{ $category->name }}
                    </td>

                    <td class="px-6 py-4 text-gray-400 max-w-xs truncate">
                        {{ $category->description ?? '-' }}
                    </td>

                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-xs 
                                     bg-emerald-500/20 text-emerald-400 
                                     rounded-full">
                            {{ $category->slug }}
                        </span>
                    </td>

                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="{{ route('admin.categories.edit', $category) }}"
                           class="px-4 py-2 rounded-lg 
                                  bg-white/10 hover:bg-white/20 
                                  transition text-white text-xs">
                            Edit
                        </a>

                        <form x-data
                              action="{{ route('admin.categories.destroy', $category) }}"
                              method="POST"
                              class="inline">
                            @csrf
                            @method('DELETE')

                            <button type="button"
                                @click="$store.confirm.show(
                                    'Hapus Category',
                                    'Yakin ingin menghapus category {{ $category->name }}?',
                                    () => $el.closest('form').submit()
                                )"
                                class="px-4 py-2 rounded-lg 
                                       bg-red-500 hover:bg-red-400 
                                       text-black font-semibold text-xs transition">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center py-10 text-gray-500">
                        Belum ada category dibuat.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="p-6 border-t border-white/10">
        {{ $categories->links() }}
    </div>
</div>

@endsection
