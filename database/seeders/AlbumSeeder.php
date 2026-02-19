<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Album;
use Illuminate\Support\Str;

class AlbumSeeder extends Seeder
{
    public function run(): void
    {
        $albums = [
            [
                'title' => 'Inspirasi Visual 2026',
                'description' => 'Kumpulan foto dan video inspiratif untuk membangun kreativitas.',
                'cover' => null,
                'is_featured' => true,
                'order' => 1,
            ],
            [
                'title' => 'Dokumentasi Event Developer',
                'description' => 'Momen penting dalam perjalanan komunitas developer.',
                'cover' => null,
                'is_featured' => false,
                'order' => 2,
            ],
            [
                'title' => 'Konten Edukasi & Tutorial',
                'description' => 'Visual pendukung materi pembelajaran teknologi.',
                'cover' => null,
                'is_featured' => false,
                'order' => 3,
            ],
        ];

        foreach ($albums as $album) {
            Album::create([
                'title' => $album['title'],
                'slug' => Str::slug($album['title']),
                'description' => $album['description'],
                'cover' => $album['cover'],
                'is_featured' => $album['is_featured'],
                'order' => $album['order'],
            ]);
        }
    }
}
