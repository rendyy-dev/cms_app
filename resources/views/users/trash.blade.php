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

    {{-- Table --}}
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
                                <button
                                    @click="openModal(
                                        '{{ route('admin.users.restore', $user->id) }}',
                                        'POST',
                                        'Yakin ingin merestore user ini?'
                                    )"
                                    class="px-3 py-1.5 text-sm rounded-lg bg-green-500/20 hover:bg-green-500 text-green-400 transition">
                                    Restore
                                </button>

                                {{-- Force Delete --}}
                                <button
                                    @click="openModal(
                                        '{{ route('admin.users.forceDelete', $user->id) }}',
                                        'DELETE',
                                        'User akan dihapus permanen. Lanjutkan?'
                                    )"
                                    class="px-3 py-1.5 text-sm rounded-lg bg-red-500/20 hover:bg-red-500 text-red-400 transition">
                                    Hapus Permanen
                                </button>

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
