@extends('layouts.super_admin')

@section('content')
<div class="flex items-center justify-between mb-8">
    <h2 class="text-2xl font-bold">Daftar E-book</h2>
    <a href="{{ route('admin.ebooks.create') }}"
       class="bg-emerald-500 text-black px-4 py-2 rounded-lg font-semibold hover:bg-emerald-400 transition">
        Tambah E-book
    </a>
</div>

<div class="bg-black/40 border border-white/10 rounded-2xl overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-white/5 text-gray-400 text-sm">
            <tr>
                <th class="px-6 py-4">Judul</th>
                <th class="px-6 py-4">Author</th>
                <th class="px-6 py-4">Kategori</th>
                <th class="px-6 py-4">Published</th>
                <th class="px-6 py-4 text-right">Aksi</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-white/5">
            @forelse($ebooks as $ebook)
                <tr class="hover:bg-white/5 transition">
                    <td class="px-6 py-4">{{ $ebook->title }}</td>
                    <td class="px-6 py-4">{{ $ebook->author }}</td>
                    <td class="px-6 py-4 text-gray-400">{{ $ebook->category?->name ?? '-' }}</td>
                    <td class="px-6 py-4">{{ $ebook->published_at?->format('d M Y') ?? '-' }}</td>
                    <td class="px-6 py-4 text-right flex justify-end gap-2">

                        <a href="{{ route('admin.ebooks.show', $ebook) }}"
                           class="px-3 py-1 bg-white/10 rounded-lg text-sm hover:bg-white/20">
                            View
                        </a>

                        <a href="{{ route('admin.ebooks.edit', $ebook) }}"
                           class="px-3 py-1 bg-white/10 rounded-lg text-sm hover:bg-white/20">
                            Edit
                        </a>

                        <form method="POST"
                              action="{{ route('admin.ebooks.destroy', $ebook) }}"
                              x-data
                              @submit.prevent="$store.confirm.show(
                                'Hapus E-book',
                                'E-book ini akan terhapus permanen.',
                                () => $el.submit()
                              )">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                class="px-3 py-1 bg-red-500 text-black rounded-lg text-sm hover:bg-red-400">
                                Hapus
                            </button>
                        </form>

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-6 text-center text-gray-500">
                        Belum ada e-book.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $ebooks->links() }}
</div>

<div class="mt-4">
    <a href="{{ route('admin.ebooks.trashed') }}" class="text-emerald-400 underline">Lihat E-book Terhapus</a>
</div>
@endsection
