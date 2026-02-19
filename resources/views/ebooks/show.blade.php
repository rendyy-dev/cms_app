@extends('layouts.super_admin')

@section('content')
<h1 class="text-2xl font-bold mb-6">{{ $ebook->title }}</h1>

<div class="space-y-3 bg-gray-900 p-6 rounded-lg border border-white/10">
    <p><strong>Author:</strong> {{ $ebook->author ?? '-' }}</p>
    <p><strong>Kategori:</strong> {{ $ebook->category?->name ?? '-' }}</p>
    <p><strong>Tanggal Terbit:</strong> {{ $ebook->published_at?->format('d M Y') ?? '-' }}</p>
    <p><strong>Deskripsi:</strong></p>
    <p class="whitespace-pre-line">{{ $ebook->description ?? '-' }}</p>
    @if($ebook->file_path)
    <p class="mt-2">
        <a href="{{ asset('storage/'.$ebook->file_path) }}" target="_blank" class="px-3 py-2 bg-emerald-500 hover:bg-emerald-400 text-black rounded font-semibold">Download / Preview</a>
    </p>
    @endif
</div>

<div class="mt-4">
    <a href="{{ route('admin.ebooks.index') }}" class="px-4 py-2 bg-gray-700 rounded hover:bg-gray-600">Kembali</a>
</div>
@endsection
