<div class="space-y-6">

    <div>
        <label class="block text-sm mb-2">Judul Album</label>
        <input type="text"
               name="title"
               value="{{ old('title', $album->title ?? '') }}"
               class="w-full px-4 py-3 rounded-lg bg-black/60 border border-white/10 focus:outline-none">
    </div>

    <div>
        <label class="block text-sm mb-2">Deskripsi Album</label>
        <textarea name="description"
                  rows="4"
                  class="w-full px-4 py-3 rounded-lg bg-black/60 border border-white/10 focus:outline-none">{{ old('description', $album->description ?? '') }}</textarea>
    </div>

    <div>
        <label class="block text-sm mb-2">Cover</label>
        <input type="file" name="cover"
               class="w-full px-4 py-3 rounded-lg bg-black/60 border border-white/10">
    </div>

    <div class="flex items-center gap-3">
        <input type="checkbox"
               name="is_featured"
               value="1"
               {{ old('is_featured', $album->is_featured ?? false) ? 'checked' : '' }}>
        <label>Prioritas / Album Unggulan ?</label>
    </div>

    <div>
        <label class="block text-sm mb-2">Album Tampil ke Berapa?</label>
        <input type="number"
               name="order"
               value="{{ old('order', $album->order ?? 0) }}"
               class="w-full px-4 py-3 rounded-lg bg-black/60 border border-white/10">
    </div>

    {{-- Multiple upload only on edit --}}
    @isset($album)
        <div>
            <label class="block text-sm mb-2">Tambah Banyak Foto</label>
            <input type="file"
                   name="photos[]"
                   multiple
                   class="w-full px-4 py-3 rounded-lg bg-black/60 border border-white/10">
        </div>
    @endisset

    <div class="flex justify-end gap-3">
        <a href="{{ route('admin.albums.index') }}"
           class="px-4 py-2 bg-white/10 rounded-lg hover:bg-white/20">
            Batal
        </a>

        <button type="submit"
                class="px-4 py-2 bg-emerald-500 text-black font-semibold rounded-lg hover:bg-emerald-400">
            Simpan
        </button>
    </div>

</div>
