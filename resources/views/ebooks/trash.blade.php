@extends('layouts.super_admin')

@section('content')
<h1 class="text-2xl font-bold mb-6">E-book Terhapus</h1>

@if(session('success'))
<div class="mb-4 p-3 bg-green-600 text-black rounded">
    {{ session('success') }}
</div>
@endif

<div class="overflow-x-auto bg-gray-900 rounded-lg border border-white/10">
    <table class="min-w-full divide-y divide-white/10">
        <thead class="bg-black/50">
            <tr>
                <th class="px-4 py-3 text-left">Judul</th>
                <th class="px-4 py-3 text-left">Author</th>
                <th class="px-4 py-3 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/10">
            @forelse($ebooks as $ebook)
            <tr>
                <td class="px-4 py-3">{{ $ebook->title }}</td>
                <td class="px-4 py-3">{{ $ebook->author }}</td>
                <td class="px-4 py-3 flex justify-end gap-2">
                    <!-- Restore -->
                    <form action="{{ route('admin.ebooks.restore', $ebook->id) }}" method="POST" x-data @submit.prevent="$store.confirm.show('Restore E-book', 'Apakah kamu yakin ingin mengembalikan e-book ini?', () => $el.submit())">
                        @csrf
                        <button type="submit" class="px-3 py-1 bg-emerald-500 hover:bg-emerald-400 text-black rounded text-sm">
                            Restore
                        </button>
                    </form>

                    <!-- Hapus Permanen -->
                    <form action="{{ route('admin.ebooks.forceDelete', $ebook->id) }}" method="POST" x-data @submit.prevent="$store.confirm.show('Hapus Permanen', 'E-book akan dihapus permanen! Yakin?', () => $el.submit())">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3 py-1 bg-red-600 hover:bg-red-500 text-black rounded text-sm">
                            Hapus Permanen
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="px-4 py-6 text-center text-gray-500">
                    Belum ada e-book yang dihapus.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $ebooks->links() }}
</div>

<div class="mt-4">
    <a href="{{ route('admin.ebooks.index') }}" class="text-emerald-400 underline">Kembali ke Daftar E-book</a>
</div>
@endsection
