@extends('layouts.super_admin')

@section('content')
<div class="max-w-3xl mx-auto">
    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-emerald-400">Tambah User Baru</h1>
        <p class="text-gray-400 mt-1 text-sm">
            Buat akun baru dan tentukan perannya
        </p>
    </div>

    {{-- Card --}}
    <div class="bg-black/40 border border-white/10 rounded-xl p-6">
        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm text-gray-300 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="w-full bg-black/50 border-white/10 text-gray-100 rounded-lg px-3 py-2
                               focus:border-emerald-400 focus:ring-emerald-400">
                    @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm text-gray-300 mb-1">Username</label>
                    <input type="text" name="username" value="{{ old('username') }}"
                        class="w-full bg-black/50 border-white/10 text-gray-100 rounded-lg px-3 py-2
                               focus:border-emerald-400 focus:ring-emerald-400">
                    @error('username')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label class="block text-sm text-gray-300 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="w-full bg-black/50 border-white/10 text-gray-100 rounded-lg px-3 py-2
                           focus:border-emerald-400 focus:ring-emerald-400">
                @error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Password --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <x-password-input name="password" label="Password" />

                <x-password-input
                    name="password_confirmation" label="Konfirmasi Password"/>
            </div>

            {{-- Role --}}
            <div>
                <label class="block text-sm text-gray-300 mb-1">Role</label>
                <select name="role_id"
                    class="w-full bg-black/50 border-white/10 text-gray-100 rounded-lg px-3 py-2
                           focus:border-emerald-400 focus:ring-emerald-400">
                    <option value="">-- Pilih Role --</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" @selected(old('role_id')==$role->id)>
                            {{ ucfirst(str_replace('_',' ', $role->name)) }}
                        </option>
                    @endforeach
                </select>
                @error('role_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Actions --}}
            <div class="flex justify-end gap-3 pt-4 border-t border-white/10">
                <a href="{{ route('admin.users.index') }}"
                   class="px-5 py-2 rounded-lg border border-white/20 text-gray-300 hover:bg-white/5 transition">
                    Batal
                </a>

                <button type="submit"
                    class="px-6 py-2 bg-emerald-500 text-black rounded-lg font-semibold
                           hover:bg-emerald-400 transition">
                    Simpan User
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
