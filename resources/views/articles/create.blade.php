@extends('layouts.super_admin')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Create Article</h1>

    <div class="bg-black/60 border border-white/10 rounded-xl p-6">
        <form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data">
            @include('articles._form')
        </form>
    </div>
@endsection
