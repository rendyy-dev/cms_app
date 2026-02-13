@csrf

<div class="space-y-6">

    {{-- Title --}}
    <div>
        <label class="block text-sm font-medium mb-2">Title</label>
        <input
            type="text"
            id="preview-title"
            name="title"
            value="{{ old('title', $article->title ?? '') }}"
            class="w-full px-4 py-3 rounded-lg bg-black/60 border border-white/10 
                   focus:outline-none focus:ring-2 focus:ring-emerald-500 text-gray-200"
            required
        >
        @error('title')
            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Category --}}
    <div>
        <label class="block text-sm font-medium mb-2">Category</label>
        <select 
            name="category_id"
            class="w-full px-4 py-3 rounded-lg bg-black/60 border border-white/10 
                   focus:outline-none focus:ring-2 focus:ring-emerald-500 text-gray-200"
            required
        >
            <option value="">-- Select Category --</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}"
                    {{ old('category_id', $article->category_id ?? '') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('category_id')
            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Content --}}
    <div>
        <label class="block text-sm font-medium mb-2">Content</label>
        <textarea id="editor" name="content">{{ old('content', $article->content ?? '') }}</textarea>
        @error('content')
            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Summary --}}
    <div>
        <label class="block text-sm font-medium mb-2">Summary</label>
        <textarea
            id="preview-summary"
            name="summary"
            rows="3"
            class="w-full px-4 py-3 rounded-lg bg-black/60 border border-white/10 
                   focus:outline-none focus:ring-2 focus:ring-emerald-500 text-gray-200"
        >{{ old('summary', $article->summary ?? '') }}</textarea>
    </div>

    {{-- Cover --}}
    <div>
        <label class="block text-sm font-medium mb-2">Cover Image</label>
        <input 
            type="file" 
            name="cover"
            class="w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 
                   file:rounded-lg file:border-0 file:bg-emerald-500 
                   file:text-black file:font-semibold hover:file:bg-emerald-400"
        >
        @error('cover')
            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- SEO --}}
    <div class="border-t border-white/10 pt-6 space-y-4">
        <h2 class="text-lg font-semibold">SEO Settings</h2>

        <div>
            <label class="block text-sm mb-2">Meta Title</label>
            <input 
                type="text" 
                name="meta_title"
                value="{{ old('meta_title', $article->meta_title ?? '') }}"
                class="w-full px-4 py-3 rounded-lg bg-black/60 border border-white/10 text-gray-200"
            >
        </div>

        <div>
            <label class="block text-sm mb-2">Meta Description</label>
            <textarea 
                name="meta_description" 
                rows="3"
                class="w-full px-4 py-3 rounded-lg bg-black/60 border border-white/10 text-gray-200"
            >{{ old('meta_description', $article->meta_description ?? '') }}</textarea>
        </div>

        <div>
            <label class="block text-sm mb-2">Meta Keywords</label>
            <input 
                type="text" 
                name="meta_keywords"
                value="{{ old('meta_keywords', $article->meta_keywords ?? '') }}"
                class="w-full px-4 py-3 rounded-lg bg-black/60 border border-white/10 text-gray-200"
            >
        </div>
    </div>

    {{-- ACTION BUTTONS --}}
    <div class="flex items-center gap-3 pt-4">

        {{-- Save Draft --}}
        <button type="submit"
                name="action"
                value="draft"
                class="px-5 py-2 rounded-lg bg-gray-600 text-white font-semibold 
                       hover:bg-gray-500 transition">
            Save
        </button>

        {{-- Submit --}}
        <button type="submit"
                name="action"
                value="submit"
                class="px-5 py-2 rounded-lg bg-yellow-500 text-black font-semibold 
                       hover:bg-yellow-400 transition">
            Submit
        </button>

        {{-- Preview --}}
        <button type="button"
            onclick="openPreview()"
            class="px-5 py-2 rounded-lg border border-white/10 hover:bg-white/10 transition">
            Preview
        </button>

        {{-- Cancel --}}
        <a href="{{ route('articles.index') }}"
           class="px-5 py-2 rounded-lg border border-white/10 hover:bg-white/10 transition">
            Cancel
        </a>

    </div>

</div>


@push('scripts')
<script>
let editorInstance;

document.addEventListener('DOMContentLoaded', function () {
    ClassicEditor
        .create(document.querySelector('#editor'), {
            toolbar: [
                'heading', '|',
                'bold', 'italic', 'link', '|',
                'bulletedList', 'numberedList', '|',
                'blockQuote', 'undo', 'redo'
            ]
        })
        .then(editor => {
            editorInstance = editor;
        })
        .catch(error => console.error(error));
});

function openPreview() {
    document.getElementById('modal-title').innerText =
        document.getElementById('preview-title').value;

    document.getElementById('modal-summary').innerText =
        document.getElementById('preview-summary').value;

    document.getElementById('modal-content').innerHTML =
        editorInstance.getData();

    document.getElementById('previewModal').classList.remove('hidden');
}

function closePreview() {
    document.getElementById('previewModal').classList.add('hidden');
}
</script>

<style>
.ck-editor__editable {
    background: #0f0f0f !important;
    color: #e5e5e5 !important;
    min-height: 300px;
    padding: 20px !important;
    border: 1px solid rgba(255,255,255,0.1) !important;
}

.ck-editor__editable h1 { font-size: 2rem; font-weight: 700; }
.ck-editor__editable h2 { font-size: 1.6rem; font-weight: 600; }
.ck-editor__editable h3 { font-size: 1.3rem; font-weight: 600; }

.ck-toolbar {
    background: #111 !important;
    border: 1px solid rgba(255,255,255,0.1) !important;
}

.ck.ck-toolbar .ck-button .ck-icon {
    color: #ffffff !important;
    fill: #ffffff !important;
}

.ck.ck-toolbar .ck-button:hover .ck-icon,
.ck.ck-toolbar .ck-button.ck-on .ck-icon {
    color: #10b981 !important;
    fill: #10b981 !important;
}
</style>
@endpush
