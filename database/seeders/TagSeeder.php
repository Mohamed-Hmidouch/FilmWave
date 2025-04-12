<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            'popular',
            'trending',
            'new',
            'award-winning',
            'classic',
            'family-friendly',
            'mature',
            'action',
            'adventure',
            'comedy',
            'drama',
            'fantasy',
            'horror',
            'mystery',
            'romance',
            'sci-fi',
            'thriller',
            'animation',
            'documentary'
        ];

        foreach ($tags as $tagName) {
            Tag::firstOrCreate(['name' => $tagName]);
        }
    }
}
