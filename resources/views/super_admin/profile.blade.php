@extends('layouts.super_admin')

@section('content')

<h2 class="text-2xl font-bold mb-6">Profile</h2>

@if(session('success'))
    <div class="mb-4 p-3 bg-emerald-500 text-black rounded">
        {{ session('success') }}
    </div>
@endif

<form method="POST"
      action="{{ route('super_admin.profile.update') }}"
      enctype="multipart/form-data"
      class="space-y-6 max-w-xl">

    @csrf
    @method('PATCH')

    <input type="hidden" name="current_password" id="current_password_input">

    {{-- Avatar --}}
    <div>
        <label class="block mb-2 text-sm">Avatar</label>

        @if($user->avatar)
            <img src="{{ asset('storage/'.$user->avatar) }}"
                 class="w-24 h-24 rounded-full object-cover mb-3">
        @endif

        <input type="file" name="avatar"
               class="block w-full text-sm bg-white/5 border border-white/10 rounded p-2">
    </div>

    {{-- Name --}}
    <div>
        <label class="block mb-2 text-sm">Name</label>
        <input type="text" name="name"
               value="{{ old('name',$user->name) }}"
               class="w-full bg-white/5 border border-white/10 rounded p-2">
    </div>

    {{-- Email --}}
    <div>
        <label class="block mb-2 text-sm">Email</label>
        <input type="email" name="email"
               value="{{ old('email',$user->email) }}"
               class="w-full bg-white/5 border border-white/10 rounded p-2">
    </div>

    {{-- Username --}}
    <div>
        <label class="block mb-2 text-sm">Username</label>
        <input type="text" name="username"
               value="{{ old('username',$user->username) }}"
               class="w-full bg-white/5 border border-white/10 rounded p-2">
    </div>

    {{-- Telepon --}}
    <div>
        <label class="block mb-2 text-sm">Telepon</label>
        <input type="text" name="telepon"
               value="{{ old('telepon',$user->telepon) }}"
               class="w-full bg-white/5 border border-white/10 rounded p-2">
    </div>

    {{-- Alamat --}}
    <div>
        <label class="block mb-2 text-sm">Alamat</label>
        <textarea name="alamat"
                  class="w-full bg-white/5 border border-white/10 rounded p-2">{{ old('alamat',$user->alamat) }}</textarea>
    </div>

    <button type="button"
            onclick="openPasswordModal()"
            class="px-4 py-2 bg-emerald-500 text-black font-semibold rounded hover:bg-emerald-400 transition">
        Save Changes
    </button>
</form>

<!-- Password Confirmation Modal -->
<div id="passwordModal"
     class="fixed inset-0 bg-black/60 hidden items-center justify-center z-50">

    <div class="bg-gray-900 p-6 rounded-lg w-full max-w-md border border-white/10">
        <h3 class="text-lg font-semibold mb-4">Konfirmasi Password</h3>

        <input type="password"
               id="password_confirmation_field"
               placeholder="Masukkan password akun"
               class="w-full bg-white/5 border border-white/10 rounded p-2 mb-4">

        <div class="flex justify-end gap-3">
            <button onclick="closePasswordModal()"
                    class="px-4 py-2 bg-gray-600 rounded hover:bg-gray-500">
                Batal
            </button>

            <button onclick="submitProfileForm()"
                    class="px-4 py-2 bg-emerald-500 text-black font-semibold rounded hover:bg-emerald-400">
                Konfirmasi
            </button>
        </div>
    </div>
</div>

<script>
    function openPasswordModal() {
        document.getElementById('passwordModal').classList.remove('hidden');
        document.getElementById('passwordModal').classList.add('flex');
    }

    function closePasswordModal() {
        document.getElementById('passwordModal').classList.add('hidden');
        document.getElementById('passwordModal').classList.remove('flex');
    }

    function submitProfileForm() {
        const password = document.getElementById('password_confirmation_field').value;

        if (!password) {
            alert('Password wajib diisi.');
            return;
        }

        document.getElementById('current_password_input').value = password;

        document.querySelector('form').submit();
    }
</script>


@endsection
