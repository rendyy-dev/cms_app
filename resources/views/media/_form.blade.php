<div class="space-y-6">

    {{-- Album --}}
    <div>
        <label class="block text-sm mb-2">Album (Optional)</label>

        <select name="album_id"
                class="w-full px-4 py-3 rounded-xl bg-black border border-white/10 focus:ring-emerald-500">
            <option value="">No Album</option>
            @foreach($albums as $album)
                <option value="{{ $album->id }}"
                    {{ old('album_id', $media->album_id ?? '') == $album->id ? 'selected' : '' }}>
                    {{ $album->title }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- File (Foto) --}}
    <div>
        <label class="block text-sm mb-2">Foto (Hanya JPG/PNG/WebP)</label>
        <input type="file" name="file"
            class="w-full px-4 py-3 rounded-xl bg-black border border-white/10">
    </div>

    {{-- Video URL --}}
    <div>
        <label class="block text-sm mb-2">Video URL (YouTube / TikTok)</label>
        <input type="url" name="video_url"
            value="{{ old('video_url', $media->video_url ?? '') }}"
            class="w-full px-4 py-3 rounded-xl bg-black border border-white/10">
    </div>

    {{-- Preview --}}
    @if(isset($media))
        <div class="mt-4">
            @if($media->isImage())
                <img src="{{ $media->url }}" class="w-40 rounded-lg">
            @elseif($media->isVideo())
                {!! $media->embed_html !!}
            @endif
        </div>
    @endif

    {{-- Title --}}
    <div>
        <label class="block text-sm mb-2">Title</label>
        <input type="text"
               name="title"
               value="{{ old('title', $media->title ?? '') }}"
               class="w-full px-4 py-3 rounded-xl bg-black border border-white/10">
    </div>

    {{-- Description --}}
    <div>
        <label class="block text-sm mb-2">Description</label>
        <textarea name="description"
                  rows="4"
                  class="w-full px-4 py-3 rounded-xl bg-black border border-white/10">{{ old('description', $media->description ?? '') }}</textarea>
    </div>

    {{-- Order --}}
    <div>
        <label class="block text-sm mb-2">Order</label>
        <input type="number"
               name="order"
               value="{{ old('order', $media->order ?? 0) }}"
               class="w-full px-4 py-3 rounded-xl bg-black border border-white/10">
    </div>

    {{-- Featured --}}
    <div class="flex items-center gap-3">
        <input type="checkbox"
               name="is_featured"
               value="1"
               {{ old('is_featured', $media->is_featured ?? false) ? 'checked' : '' }}
               class="w-4 h-4">
        <label>Featured</label>
    </div>

    {{-- Submit --}}
    <div class="flex justify-end gap-3 pt-4">
        <a href="{{ route('admin.media.index') }}"
           class="px-4 py-2 bg-white/10 rounded-lg hover:bg-white/20">
            Batal
        </a>

        <button type="submit"
                class="px-6 py-3 rounded-xl bg-emerald-500 text-black font-semibold hover:bg-emerald-400 transition">
            Simpan
        </button>
    </div>

</div>
