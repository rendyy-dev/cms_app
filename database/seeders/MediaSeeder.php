<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Album;
use App\Models\Media;

class MediaSeeder extends Seeder
{
    public function run(): void
    {
        $albums = Album::all();

        foreach ($albums as $album) {

            // Dummy Images (gunakan placeholder online dulu)
            for ($i = 1; $i <= 4; $i++) {
                Media::create([
                    'album_id' => $album->id,
                    'file_path' => null,
                    'video_url' => null,
                    'type' => 'image',
                    'title' => 'Sample Image '.$i,
                    'description' => 'Contoh gambar ke-'.$i.' untuk album '.$album->title,
                    'order' => $i,
                    'is_featured' => $i === 1,
                ]);
            }

            // Dummy YouTube Video
            Media::create([
                'album_id' => $album->id,
                'file_path' => null,
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'type' => 'video',
                'title' => 'Sample YouTube Video',
                'description' => 'Contoh embed video YouTube.',
                'order' => 10,
                'is_featured' => false,
            ]);

            // Dummy TikTok Video
            Media::create([
                'album_id' => $album->id,
                'file_path' => null,
                'video_url' => 'https://www.tiktok.com/@scout2015/video/6718335390845095173',
                'type' => 'video',
                'title' => 'Sample TikTok Video',
                'description' => 'Contoh embed video TikTok.',
                'order' => 11,
                'is_featured' => false,
            ]);
        }
    }
}
