@extends('layouts.super_admin')

@section('content')

<div class="mb-8">
    <h1 class="text-2xl font-bold">Tambah Media</h1>
</div>

<form action="{{ route('admin.media.store') }}"
      method="POST"
      enctype="multipart/form-data"
      class="bg-black/40 p-6 rounded-2xl border border-white/10">

    @csrf

    @include('media._form', [
        'media' => null
    ])

</form>

@endsection
