<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $author = User::whereHas('role', function ($query) {
            $query->where('name', 'author');
        })->first() ?? User::first();

        $category = Category::first();

        if (! $author || ! $category) {
            return;
        }

        $articles = [
            [
                'title' => 'Mengenal Laravel untuk CMS Modern',
                'slug' => 'mengenal-laravel-untuk-cms-modern',
                'summary' => 'Pengantar Laravel untuk membangun CMS yang terstruktur, aman, dan scalable.',
                'content' => '<p>Laravel menawarkan fondasi yang solid untuk CMS modern. Mulai dari routing, ORM, hingga sistem autentikasi, semuanya tersedia dengan rapi.</p><p>Dengan arsitektur MVC, tim developer juga lebih mudah menjaga kualitas kode saat aplikasi berkembang.</p>',
                'meta_title' => 'Mengenal Laravel untuk CMS Modern',
                'meta_description' => 'Belajar dasar Laravel untuk membangun CMS modern yang aman dan scalable.',
                'meta_keywords' => 'laravel,cms,web development',
                'cover' => null,
                'image' => null,
                'status' => 'published',
                'rejection_reason' => null,
                'published_at' => now()->subDays(10),
            ],
            [
                'title' => 'Tips Menulis Artikel SEO Friendly',
                'slug' => 'tips-menulis-artikel-seo-friendly',
                'summary' => 'Langkah sederhana agar artikel lebih mudah ditemukan di mesin pencari.',
                'content' => '<p>Artikel SEO friendly bukan sekadar menaruh keyword. Kamu perlu struktur heading yang baik, internal link, dan meta description yang relevan.</p><p>Pastikan juga konten tetap natural agar nyaman dibaca pengguna.</p>',
                'meta_title' => 'Tips Menulis Artikel SEO Friendly',
                'meta_description' => 'Praktik terbaik menulis artikel SEO friendly untuk website CMS.',
                'meta_keywords' => 'seo,artikel,content writing',
                'cover' => null,
                'image' => null,
                'status' => 'published',
                'rejection_reason' => null,
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Workflow Editorial untuk Tim Kecil',
                'slug' => 'workflow-editorial-untuk-tim-kecil',
                'summary' => 'Contoh alur kerja dari draft, review, hingga publish dalam tim konten kecil.',
                'content' => '<p>Workflow editorial membantu tim tetap konsisten. Gunakan status draft, pending, dan published agar proses review lebih jelas.</p><p>Dokumentasi sederhana juga penting supaya kualitas artikel tetap terjaga.</p>',
                'meta_title' => 'Workflow Editorial untuk Tim Kecil',
                'meta_description' => 'Membuat workflow editorial yang efektif untuk tim konten kecil.',
                'meta_keywords' => 'editorial,workflow,cms',
                'cover' => null,
                'image' => null,
                'status' => 'pending',
                'rejection_reason' => null,
                'published_at' => null,
            ],
            [
                'title' => 'Strategi Konten Bulanan untuk Brand',
                'slug' => 'strategi-konten-bulanan-untuk-brand',
                'summary' => 'Cara menyusun kalender konten bulanan yang selaras dengan tujuan brand.',
                'content' => '<p>Strategi konten bulanan sebaiknya dimulai dari objective yang terukur. Setelah itu, petakan tema mingguan dan KPI yang ingin dicapai.</p>',
                'meta_title' => 'Strategi Konten Bulanan untuk Brand',
                'meta_description' => 'Panduan menyusun strategi konten bulanan untuk kebutuhan brand.',
                'meta_keywords' => 'strategi konten,brand,marketing',
                'cover' => null,
                'image' => null,
                'status' => 'draft',
                'rejection_reason' => null,
                'published_at' => null,
            ],
        ];

        foreach ($articles as $item) {
            Article::updateOrCreate(
                ['slug' => $item['slug']],
                array_merge($item, [
                    'user_id' => $author->id,
                    'category_id' => $category->id,
                ])
            );
        }
    }
}
