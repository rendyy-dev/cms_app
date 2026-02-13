@extends('layouts.super_admin')

@section('content')
<div class="max-w-7xl mx-auto">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-3xl font-bold text-emerald-400">Manajemen User</h1>
            <p class="text-gray-400 mt-1 text-sm">
                Kelola akun dan peran pengguna sistem
            </p>
        </div>

        <a href="{{ route('admin.users.create') }}"
           class="inline-flex items-center gap-2 px-5 py-2 bg-emerald-500 text-black rounded-lg font-semibold hover:bg-emerald-400 transition">
            + Tambah User
        </a>
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

                    {{-- Skip jika role super_admin --}}
                    @continue(optional($user->role)->name === 'super_admin')

                    <tr class="hover:bg-white/5 transition">
                        <td class="px-6 py-4 font-medium">
                            {{ $user->name }}
                        </td>

                        <td class="px-6 py-4 text-gray-300">
                            {{ $user->username }}
                        </td>

                        <td class="px-6 py-4 text-gray-300">
                            {{ $user->email }}
                        </td>

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

                                {{-- Logic: Admin tidak bisa edit/hapus sesama admin --}}
                                @php
                                    $currentUser = auth()->user();
                                    $isTargetAdmin = optional($user->role)->name === 'admin';
                                    $isCurrentAdmin = optional($currentUser->role)->name === 'admin';
                                    $isSelf = $currentUser->id === $user->id;
                                @endphp

                                @if (!($isCurrentAdmin && $isTargetAdmin) && !$isSelf)
                                    
                                    <a href="{{ route('admin.users.edit', $user) }}"
                                       class="px-3 py-1.5 text-sm rounded-lg bg-white/10 hover:bg-emerald-500/20 text-emerald-400 transition">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                          onsubmit="return confirm('Hapus user ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1.5 text-sm rounded-lg bg-white/10 hover:bg-red-500/20 text-red-400 transition">
                                            Hapus
                                        </button>
                                    </form>

                                @else
                                    <span class="text-gray-500 text-sm italic">
                                        Tidak diizinkan
                                    </span>
                                @endif

                            </div>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-400">
                            Belum ada user yang terdaftar.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
