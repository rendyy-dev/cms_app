@extends('layouts.super_admin')

@section('content')
<div class="max-w-2xl">
    <h1 class="text-2xl font-bold mb-6">Edit Role</h1>

    <form action="{{ route('super_admin.roles.update', $role) }}" method="POST"
          class="bg-white/5 border border-white/10 p-6 rounded-xl space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label class="block mb-2 text-sm font-medium">Name</label>
            <input type="text"
                   name="name"
                   value="{{ old('name', $role->name) }}"
                   class="w-full px-4 py-2 bg-black border border-white/10 rounded-lg focus:outline-none focus:border-emerald-400">

            @error('name')
                <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block mb-2 text-sm font-medium">Label</label>
            <input type="text"
                   name="label"
                   value="{{ old('label', $role->label) }}"
                   class="w-full px-4 py-2 bg-black border border-white/10 rounded-lg focus:outline-none focus:border-emerald-400">

            @error('label')
                <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-between">
            <a href="{{ route('super_admin.roles.index') }}"
               class="px-4 py-2 bg-white/10 rounded-lg hover:bg-white/20 transition">
                Kembali
            </a>

            <button type="submit"
                    class="px-4 py-2 bg-emerald-500 text-black font-semibold rounded-lg hover:bg-emerald-400 transition">
                Update
            </button>
        </div>
    </form>
</div>
@endsection
