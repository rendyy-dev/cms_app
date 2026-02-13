@extends('layouts.super_admin')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-3xl font-bold text-emerald-400">Article</h1>
        <p class="text-gray-400 mt-1 text-sm">
            Kelola article buatan author
        </p>
    </div>

    @can('create', App\Models\Article::class)
        <a href="{{ route('articles.create') }}"
           class="px-4 py-2 rounded-lg bg-emerald-500 text-black font-semibold hover:bg-emerald-400 transition">
            + New Article
        </a>
    @endcan
</div>

<div class="bg-black/60 border border-white/10 rounded-xl overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-black/80 text-gray-400">
            <tr>
                <th class="px-6 py-4 text-left">Title</th>
                <th class="px-6 py-4 text-left">Author</th>
                <th class="px-6 py-4 text-left">Status</th>
                <th class="px-6 py-4 text-left">Updated</th>
                <th class="px-6 py-4 text-right">Action</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-white/5">
        @forelse($articles as $article)
            <tr class="hover:bg-white/5 transition">

                {{-- Title --}}
                <td class="px-6 py-4 font-medium">
                    {{ $article->title }}
                </td>

                {{-- Author --}}
                <td class="px-6 py-4 text-gray-400">
                    {{ $article->user->name ?? '-' }}
                </td>

                {{-- Status --}}
                <td class="px-6 py-4 relative">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                        @if($article->isDraft()) bg-gray-700 text-gray-200
                        @elseif($article->isPending()) bg-yellow-500/20 text-yellow-400
                        @elseif($article->isRejected()) bg-red-500/20 text-red-400
                        @else bg-emerald-500/20 text-emerald-400
                        @endif">
                        {{ ucfirst($article->status) }}
                    </span>

                    {{-- Tooltip & modal for rejected reason --}}
                    @if($article->isRejected() && $article->rejection_reason)
                        <div class="group inline-block relative ml-2 cursor-pointer">
                            <button onclick="openReasonModal('{{ addslashes($article->rejection_reason) }}')"
                                    class="text-red-400">ⓘ</button>

                            {{-- Tooltip on hover --}}
                            <div class="absolute left-0 mt-2 w-64 p-3 rounded-lg bg-black border border-white/10 text-xs text-gray-300
                                        opacity-0 group-hover:opacity-100 transition pointer-events-none z-50">
                                {{ Str::limit($article->rejection_reason, 50) }}
                            </div>
                        </div>
                    @endif
                </td>

                {{-- Updated --}}
                <td class="px-6 py-4 text-gray-400">
                    {{ $article->updated_at->diffForHumans() }}
                </td>

                {{-- Actions --}}
                <td class="px-6 py-4 text-right space-x-3">

                    {{-- Edit --}}
                    @can('update', $article)
                        @if($article->status !== 'published')
                            <a href="{{ route('articles.edit', $article) }}"
                               class="text-emerald-400 hover:underline">
                                Edit
                            </a>
                        @endif
                    @endcan

                    {{-- Submit (Draft or Rejected) --}}
                    @can('submit', $article)
                        @if($article->status === 'draft' || $article->status === 'rejected')
                            <form action="{{ route('articles.submit', $article) }}" method="POST" class="inline">
                                @csrf
                                <button class="text-yellow-400 hover:underline">
                                    Submit
                                </button>
                            </form>
                        @endif
                    @endcan

                    {{-- Approve (Pending only) --}}
                    @can('approve', $article)
                        @if($article->status === 'pending')
                            <form action="{{ route('articles.approve', $article) }}" method="POST" class="inline">
                                @csrf
                                <button class="text-emerald-400 hover:underline">
                                    Publish
                                </button>
                            </form>
                        @endif
                    @endcan

                    {{-- Reject (Pending only) --}}
                    @can('reject', $article)
                        @if($article->status === 'pending')
                            <button onclick="openRejectModal({{ $article->id }})"
                                    class="text-red-400 hover:underline">
                                Reject
                            </button>
                        @endif
                    @endcan

                    {{-- Delete --}}
                    @can('delete', $article)
                        <form x-data
                            action="{{ route('articles.destroy', $article) }}"
                            method="POST"
                            class="inline">
                            @csrf
                            @method('DELETE')

                            <button type="button"
                                @click="$store.confirm.show(
                                    'Hapus Article',
                                    'Yakin ingin menghapus article {{ $article->title }}?',
                                    () => $el.closest('form').submit()
                                )"
                                class="px-4 py-2 rounded-lg 
                                    bg-red-500/80 hover:bg-red-400 
                                    text-black font-semibold text-xs transition">
                                Hapus
                            </button>
                        </form>
                    @endcan

                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                    No articles found.
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

{{-- REJECT MODAL --}}
<div id="rejectModal" class="fixed inset-0 bg-black/80 hidden z-50 flex items-center justify-center">
    <div class="bg-black border border-white/10 rounded-xl w-full max-w-md p-6">
        <h2 class="text-lg font-semibold mb-4">Reject Article</h2>
        <form id="rejectForm" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm mb-2">Reason</label>
                <textarea name="rejection_reason" rows="4" required
                          class="w-full px-4 py-3 rounded-lg bg-black/60 border border-white/10 text-gray-200"></textarea>
            </div>
            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeRejectModal()"
                        class="px-4 py-2 border border-white/10 rounded-lg">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-red-500 text-black font-semibold rounded-lg">
                    Confirm Reject
                </button>
            </div>
        </form>
    </div>
</div>

{{-- REJECTION REASON MODAL --}}
<div id="reasonModal" class="fixed inset-0 bg-black/80 hidden z-50 flex items-center justify-center">
    <div class="bg-black border border-white/10 rounded-xl w-full max-w-md p-6">
        <h2 class="text-lg font-semibold mb-4">Rejection Reason</h2>
        <p id="reasonText" class="text-gray-300 text-sm break-words"></p>
        <div class="flex justify-end mt-4">
            <button onclick="closeReasonModal()" class="px-4 py-2 border border-white/10 rounded-lg">
                Close
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
function openRejectModal(articleId) {
    const form = document.getElementById('rejectForm');
    form.action = `/articles/${articleId}/reject`;
    document.getElementById('rejectModal').classList.remove('hidden');
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
}

function openReasonModal(reason) {
    document.getElementById('reasonText').innerText = reason;
    document.getElementById('reasonModal').classList.remove('hidden');
}

function closeReasonModal() {
    document.getElementById('reasonModal').classList.add('hidden');
}
</script>
@endpush

@endsection
