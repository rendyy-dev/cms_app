<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Teknologi',
            'Programming',
            'Web Development',
            'AI & Machine Learning',
            'Lifestyle',
            'Bisnis',
            'Agama',
            'Produktivitas',
            'Opini',
            'Tutorial'
        ];

        foreach ($categories as $name) {
            Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => 'Category untuk ' . $name,
            ]);
        }
    }
}
