{{-- _form.blade.php --}}
<form action="{{ isset($article) ? route('articles.update', $article) : route('articles.store') }}"
      method="POST"
      enctype="multipart/form-data">
    @csrf
    @if(isset($article))
        @method('PUT')
    @endif

    {{-- Hidden action default --}}
    <input type="hidden" name="action" value="draft">

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
                id="preview-cover-input"
                name="cover"
                accept="image/*"
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
            <button type="submit" name="action" value="draft"
                    class="px-5 py-2 rounded-lg bg-gray-600 text-white font-semibold 
                           hover:bg-gray-500 transition">
                Save
            </button>

            <button type="submit" name="action" value="submit"
                    class="px-5 py-2 rounded-lg bg-yellow-500 text-black font-semibold 
                           hover:bg-yellow-400 transition">
                Submit
            </button>

            <button type="button"
                onclick="openPreview()"
                class="px-5 py-2 rounded-lg border border-white/10 hover:bg-white/10 transition">
                Preview
            </button>

            <a href="{{ route('articles.index') }}"
               class="px-5 py-2 rounded-lg border border-white/10 hover:bg-white/10 transition">
                Cancel
            </a>
        </div>

    </div>
</form>

{{-- Modal Preview --}}
<div id="previewModal" class="fixed inset-0 bg-black/80 z-50 hidden items-center justify-center overflow-auto transition-opacity duration-300">
    <div class="bg-gray-900 rounded-xl max-w-3xl w-full mx-4 md:mx-0 p-6 relative transform transition-transform duration-300">
        <button type="button" onclick="closePreview()" 
                class="absolute top-3 right-3 text-gray-400 hover:text-white text-xl font-bold">&times;</button>
        
        <div class="mb-4">
            <img id="modal-cover" src="" alt="Cover" class="w-full h-64 object-cover rounded-lg mb-4 hidden">
            <h2 id="modal-title" class="text-2xl font-bold mb-2"></h2>
            <p id="modal-summary" class="text-gray-400 mb-4"></p>
            <div id="modal-content" class="prose prose-invert max-w-full overflow-auto"></div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let editorInstance;
let coverFileData = null;

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

    // Cover input preview
    const coverInput = document.getElementById('preview-cover-input');
    coverInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                coverFileData = event.target.result;
            }
            reader.readAsDataURL(file);
        } else {
            coverFileData = null;
        }
    });
});

function openPreview() {
    const modal = document.getElementById('previewModal');

    // Title
    document.getElementById('modal-title').innerText = document.getElementById('preview-title').value;

    // Summary
    document.getElementById('modal-summary').innerText = document.getElementById('preview-summary').value;

    // Content
    document.getElementById('modal-content').innerHTML = editorInstance.getData();

    // Cover
    const modalCover = document.getElementById('modal-cover');
    if (coverFileData) {
        modalCover.src = coverFileData;
        modalCover.classList.remove('hidden');
    } else {
        modalCover.classList.add('hidden');
    }

    // Show modal
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    setTimeout(() => {
        modal.style.opacity = '1';
        modal.firstElementChild.style.transform = 'translateY(0)';
    }, 10);
}

function closePreview() {
    const modal = document.getElementById('previewModal');
    modal.style.opacity = '0';
    modal.firstElementChild.style.transform = 'translateY(-20px)';
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }, 200);
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

/* Modal scrollbar */
#previewModal::-webkit-scrollbar {
    width: 6px;
}
#previewModal::-webkit-scrollbar-thumb {
    background-color: rgba(255,255,255,0.2);
    border-radius: 3px;
}
</style>
@endpush
