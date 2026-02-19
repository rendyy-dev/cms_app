@extends('layouts.super_admin')

@section('content')
<h1 class="text-2xl font-bold mb-6">Edit E-book</h1>

@if ($errors->any())
<div class="mb-4 p-3 bg-red-600 text-black rounded">
    <ul class="list-disc pl-5">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('admin.ebooks.update', $ebook) }}"
      method="POST"
      enctype="multipart/form-data"
      class="space-y-6 bg-gray-900 p-6 rounded-lg border border-white/10">
    @csrf
    @method('PUT')

    {{-- Judul --}}
    <div>
        <label class="block mb-1 font-medium">Judul *</label>
        <input type="text"
               name="title"
               value="{{ old('title', $ebook->title) }}"
               required
               class="w-full px-3 py-2 rounded bg-black/50 border border-white/20">
    </div>

    {{-- Author --}}
    <div>
        <label class="block mb-1 font-medium">Author</label>
        <input type="text"
               name="author"
               value="{{ old('author', $ebook->author) }}"
               class="w-full px-3 py-2 rounded bg-black/50 border border-white/20">
    </div>

    {{-- Kategori --}}
    <div>
        <label class="block mb-1 font-medium">Kategori</label>
        <select name="category_id"
                class="w-full px-3 py-2 rounded bg-black/50 border border-white/20">
            <option value="">-- Pilih Kategori --</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}"
                    {{ old('category_id', $ebook->category_id) == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Deskripsi --}}
    <div>
        <label class="block mb-1 font-medium">Deskripsi</label>
        <textarea name="description"
                  rows="4"
                  class="w-full px-3 py-2 rounded bg-black/50 border border-white/20">{{ old('description', $ebook->description) }}</textarea>
    </div>

    {{-- Cover --}}
    <div>
        <label class="block mb-1 font-medium">Cover</label>

        @if($ebook->cover_url)
            <div class="mb-3">
                <img src="{{ $ebook->cover_url }}"
                     class="w-40 rounded shadow">
            </div>
        @endif

        <input type="file" name="cover" class="w-full text-white">
        <p class="text-xs text-gray-400 mt-1">Kosongkan jika tidak ingin mengganti</p>
    </div>

    {{-- File Ebook --}}
    <div>
        <label class="block mb-1 font-medium">File E-book</label>
        <input type="file" name="file" class="w-full text-white">
        <p class="text-xs text-gray-400 mt-1">Kosongkan jika tidak ingin mengganti</p>
    </div>

    {{-- Access Type --}}
    <div>
        <label class="block mb-1 font-medium">Tipe Akses *</label>
        <select name="access_type"
                required
                class="w-full px-3 py-2 rounded bg-black/50 border border-white/20">
            <option value="free"
                {{ old('access_type', $ebook->access_type) == 'free' ? 'selected' : '' }}>
                Gratis
            </option>
            <option value="login"
                {{ old('access_type', $ebook->access_type) == 'login' ? 'selected' : '' }}>
                Login Required
            </option>
            <option value="paid"
                {{ old('access_type', $ebook->access_type ?? '') == 'paid' ? 'selected' : '' }}>
                Berbayar
            </option>
        </select>
    </div>

    {{-- Harga --}}
    <div>
        <label class="block mb-1 font-medium">Harga (Opsional)</label>
        <input type="number"
            name="price"
            step="0.01"
            value="{{ old('price', $ebook->price ?? '') }}"
            class="w-full px-3 py-2 rounded bg-black/50 border border-white/20">
    </div>

    {{-- WhatsApp Number --}}
    <div>
        <label class="block mb-1 font-medium">Nomor WhatsApp (untuk ebook berbayar)</label>
        <input type="text"
            name="whatsapp_number"
            placeholder="628123456789"
            value="{{ old('whatsapp_number', $ebook->whatsapp_number ?? '') }}"
            class="w-full px-3 py-2 rounded bg-black/50 border border-white/20">
    </div>

    {{-- Featured --}}
    <div class="flex items-center gap-2">
        <input type="checkbox"
               name="is_featured"
               value="1"
               {{ old('is_featured', $ebook->is_featured) ? 'checked' : '' }}>
        <label>Featured</label>
    </div>

    {{-- Published At --}}
    <div>
        <label class="block mb-2 font-medium">Tanggal Terbit</label>

        <div class="relative">
            <input type="date"
                name="published_at"
                value="{{ old('published_at', optional($ebook->published_at)->format('Y-m-d')) }}"
                class="w-42 color-white px-3 py-2 rounded bg-gray-800 text-white border border-white/20 
                        focus:border-emerald-400 focus:ring-1 focus:ring-emerald-400
                        appearance-none">
        </div>

        <p class="text-xs text-gray-400 mt-2">
            Kosongkan jika belum ingin dipublish.
        </p>
    </div>

    {{-- Buttons --}}
    <div class="flex gap-3">
        <a href="{{ route('admin.ebooks.index') }}"
           class="px-4 py-2 bg-gray-700 rounded hover:bg-gray-600">
            Kembali
        </a>

        <button type="submit"
                class="px-4 py-2 bg-emerald-500 rounded hover:bg-emerald-400 text-black font-semibold">
            Update
        </button>
    </div>
</form>
@endsection
