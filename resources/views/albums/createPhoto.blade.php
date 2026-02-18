@extends('layouts.super_admin')

@section('content')

<h2 class="text-2xl font-bold mb-6">
    Tambah Foto ke Album: {{ $album->title }}
</h2>

<form method="POST"
      action="{{ route('admin.photos.store', $album) }}"
      enctype="multipart/form-data"
      class="space-y-6">

    @csrf

    <div>
        <label class="block text-sm mb-2">Image</label>
        <input type="file" name="image"
               class="w-full bg-black/40 border border-white/10 p-3 rounded-lg">
    </div>

    <div>
        <label class="block text-sm mb-2">Caption</label>
        <input type="text" name="caption"
               class="w-full bg-black/40 border border-white/10 p-3 rounded-lg">
    </div>

    <div>
        <label class="block text-sm mb-2">Order</label>
        <input type="number" name="order" value="0"
               class="w-full bg-black/40 border border-white/10 p-3 rounded-lg">
    </div>

    <button type="submit"
            class="bg-emerald-500 text-black px-6 py-2 rounded-lg hover:bg-emerald-400">
        Simpan
    </button>
</form>

@endsection
