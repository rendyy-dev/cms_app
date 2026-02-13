@extends('layouts.super_admin')

@section('content')

<h2 class="text-2xl font-bold mb-6">Edit Category</h2>

<form action="{{ route('admin.categories.update', $category) }}" method="POST" class="space-y-4">
    @csrf
    @method('PUT')

    <div>
        <label>Nama</label>
        <input type="text" name="name"
               value="{{ $category->name }}"
               class="w-full mt-1 p-2 bg-black border border-white/10 rounded">
    </div>

    <div>
        <label>Deskripsi</label>
        <textarea name="description"
                  class="w-full mt-1 p-2 bg-black border border-white/10 rounded">
            {{ $category->description }}
        </textarea>
    </div>

    <button class="px-4 py-2 bg-emerald-500 text-black rounded hover:bg-emerald-400">
        Update
    </button>
</form>

@endsection
