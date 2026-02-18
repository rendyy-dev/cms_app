@extends('layouts.super_admin')

@section('content')

<div class="flex items-center justify-between mb-8">
    <h2 class="text-2xl font-bold">Albums</h2>

    <a href="{{ route('admin.albums.create') }}"
       class="bg-emerald-500 text-black px-4 py-2 rounded-lg font-semibold hover:bg-emerald-400 transition">
        Tambah Album
    </a>
</div>

<div class="bg-black/40 border border-white/10 rounded-2xl overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-white/5 text-gray-400 text-sm">
            <tr>
                <th class="px-6 py-4">Cover</th>
                <th class="px-6 py-4">Title</th>
                <th class="px-6 py-4">Photos</th>
                <th class="px-6 py-4">Featured</th>
                <th class="px-6 py-4 text-right">Aksi</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-white/5">
            @forelse($albums as $album)
                <tr class="hover:bg-white/5 transition">
                    <td class="px-6 py-4">
                        @if($album->cover)
                            <img src="{{ asset('storage/'.$album->cover) }}"
                                 class="w-16 h-16 object-cover rounded-lg">
                        @else
                            <div class="w-16 h-16 bg-white/10 rounded-lg"></div>
                        @endif
                    </td>

                    <td class="px-6 py-4">
                        {{ $album->title }}
                    </td>

                    <td class="px-6 py-4 text-gray-400">
                        {{ $album->photos_count }}
                    </td>

                    <td class="px-6 py-4">
                        @if($album->is_featured)
                            <span class="px-2 py-1 bg-emerald-500 text-black text-xs rounded">
                                Yes
                            </span>
                        @else
                            <span class="text-gray-500 text-xs">No</span>
                        @endif
                    </td>

                    <td class="px-6 py-4 text-right flex justify-end gap-2">

                        <a href="{{ route('admin.albums.show', $album) }}"
                           class="px-3 py-1 bg-white/10 rounded-lg text-sm hover:bg-white/20">
                            View
                        </a>

                        <a href="{{ route('admin.albums.edit', $album) }}"
                           class="px-3 py-1 bg-white/10 rounded-lg text-sm hover:bg-white/20">
                            Edit
                        </a>

                        <form method="POST"
                              action="{{ route('admin.albums.destroy', $album) }}"
                              x-data
                              @submit.prevent="$store.confirm.show(
                                'Hapus Album',
                                'Album dan semua foto akan terhapus.',
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
                        Belum ada album.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $albums->links() }}
</div>

@endsection
