@extends('layouts.super_admin')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Edit Article</h1>

    <div class="bg-black/60 border border-white/10 rounded-xl p-6">
        @if($article->isRejected())
            <div class="mb-6 p-4 bg-red-500/10 border border-red-500/30 rounded-lg">
                <h3 class="text-red-400 font-semibold mb-2">Rejection Reason</h3>
                <p class="text-gray-300 text-sm">
                    {{ $article->rejection_reason }}
                </p>
            </div>
        @endif

        <form action="{{ route('articles.update', $article) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')

            @include('articles._form', [
                'article' => $article
            ])
        </form>
    </div>
@endsection
