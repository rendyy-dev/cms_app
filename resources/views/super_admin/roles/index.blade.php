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
>

<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">Manajemen Roles</h1>

    <div class="flex gap-2">
        <a href="{{ route('super_admin.roles.create') }}"
           class="px-4 py-2 bg-emerald-500 text-black rounded-lg font-semibold hover:bg-emerald-400 transition">
            + Tambah Role
        </a>

        <a href="{{ route('super_admin.roles.trash') }}"
           class="px-4 py-2 bg-gray-700 text-white rounded-lg font-semibold hover:bg-gray-600 transition">
            Sampah
        </a>
    </div>
</div>

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


<div class="bg-white/5 border border-white/10 rounded-xl overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-white/10 text-left">
            <tr>
                <th class="px-6 py-4">Name</th>
                <th class="px-6 py-4">Label</th>
                <th class="px-6 py-4 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($roles as $role)
                <tr class="border-t border-white/10 hover:bg-white/5 transition">
                    <td class="px-6 py-4 font-medium">
                        {{ $role->name }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $role->label ?? '-' }}
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">

                        @if(!$role->isDefault())

                            <a href="{{ route('super_admin.roles.edit', $role) }}"
                               class="px-3 py-1 bg-white/10 rounded-lg hover:bg-white/20 transition">
                                Edit
                            </a>

                            <button
                                @click="openModal(
                                    '{{ route('super_admin.roles.destroy', $role) }}',
                                    'DELETE',
                                    'Role akan dipindahkan ke sampah. Lanjutkan?'
                                )"
                                class="px-3 py-1 bg-red-500/20 text-red-400 rounded-lg hover:bg-red-500/30 transition">
                                Hapus
                            </button>

                        @else
                            <span class="text-gray-500 text-xs italic">
                                Role Sistem
                            </span>
                        @endif

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="px-6 py-6 text-center text-gray-400">
                        Belum ada role tambahan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $roles->links() }}
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
