@extends('layouts.super_admin')

@section('content')
<div class="max-w-7xl mx-auto">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-3xl font-bold text-emerald-400">Sampah User</h1>
            <p class="text-gray-400 mt-1 text-sm">
                Data user yang dihapus (soft delete)
            </p>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('admin.users.index') }}"
               class="inline-flex items-center gap-2 px-5 py-2 bg-emerald-500 text-black rounded-lg font-semibold hover:bg-emerald-400 transition">
                Kembali
            </a>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="bg-black/40 border border-white/10 rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-white/10">
                <thead class="bg-white/5">
                    <tr class="text-left text-xs uppercase tracking-wider text-gray-400">
                        <th class="px-6 py-4">Nama</th>
                        <th class="px-6 py-4">Username</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Role</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-white/10 text-gray-100">
                @forelse ($users as $user)
                    <tr class="hover:bg-white/5 transition">
                        <td class="px-6 py-4 font-medium">{{ $user->name }}</td>
                        <td class="px-6 py-4 text-gray-300">{{ $user->username }}</td>
                        <td class="px-6 py-4 text-gray-300">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            @if ($user->role)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                    {{ $user->role->name === 'admin'
                                        ? 'bg-blue-500/20 text-blue-400'
                                        : 'bg-gray-500/20 text-gray-300' }}">
                                    {{ ucfirst(str_replace('_',' ', $user->role->name)) }}
                                </span>
                            @else
                                <span class="text-gray-500 text-sm">-</span>
                            @endif
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex justify-end gap-2">
                                {{-- Restore --}}
                                <form action="{{ route('admin.users.restore', $user->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="px-3 py-1.5 text-sm rounded-lg bg-green-500/20 hover:bg-green-500 text-green-400 transition">
                                        Restore
                                    </button>
                                </form>

                                {{-- Force Delete --}}
                                <form action="{{ route('admin.users.forceDelete', $user->id) }}" method="POST"
                                      onsubmit="return confirm('Hapus permanen user ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-3 py-1.5 text-sm rounded-lg bg-red-500/20 hover:bg-red-500 text-red-400 transition">
                                        Hapus Permanen
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-400">
                            Tidak ada user di sampah.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
