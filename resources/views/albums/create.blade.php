@extends('layouts.super_admin')

@section('content')

<h2 class="text-2xl font-bold mb-6">Tambah Album</h2>

<div class="bg-black/40 border border-white/10 rounded-2xl p-6">
    <form method="POST"
          action="{{ route('admin.albums.store') }}"
          enctype="multipart/form-data">
        @csrf
        @include('albums._form')
    </form>
</div>

@endsection
