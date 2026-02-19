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

<form action="{{ route('admin.ebooks.update', $ebook) }}" method="POST" enctype="multipart/form-data" class="space-y-4 bg-gray-900 p-6 rounded-lg border border-white/10">
    @csrf
    @method('PUT')
    <div>
        <label class="block mb-1">Judul</label>
        <input type="text" name="title" class="w-full px-3 py-2 rounded bg-black/50 border border-white/20" value="{{ old('title', $ebook->title) }}" required>
    </div>

    <div>
        <label class="block mb-1">Author</label>
        <input type="text" name="author" class="w-full px-3 py-2 rounded bg-black/50 border border-white/20" value="{{ old('author', $ebook->author) }}">
    </div>

    <div>
        <label class="block mb-1">Kategori</label>
        <select name="category_id" class="w-full px-3 py-2 rounded bg-black/50 border border-white/20">
            <option value="">-- Pilih Kategori --</option>
            @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ old('category_id', $ebook->category_id)==$category->id ? 'selected' : '' }}>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block mb-1">Deskripsi</label>
        <textarea name="description" class="w-full px-3 py-2 rounded bg-black/50 border border-white/20" rows="4">{{ old('description', $ebook->description) }}</textarea>
    </div>

    <div>
        <label class="block mb-1">File E-book (PDF/EPUB)</label>
        <input type="file" name="file" class="w-full text-white">
        @if($ebook->file_path)
        <p class="mt-1 text-sm text-gray-400">File saat ini: <a href="{{ asset('storage/'.$ebook->file_path) }}" target="_blank" class="underline">{{ $ebook->file_path }}</a></p>
        @endif
    </div>

    <div>
        <label class="block mb-1">Tanggal Terbit</label>
        <input type="date" name="published_at" class="w-full px-3 py-2 rounded bg-black/50 border border-white/20" value="{{ old('published_at', $ebook->published_at?->format('Y-m-d')) }}">
    </div>

    <div class="flex gap-2">
        <a href="{{ route('admin.ebooks.index') }}" class="px-4 py-2 bg-gray-700 rounded hover:bg-gray-600">Kembali</a>
        <button type="submit" class="px-4 py-2 bg-emerald-500 rounded hover:bg-emerald-400 text-black font-semibold">Update</button>
    </div>
</form>
@endsection
