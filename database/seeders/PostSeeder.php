<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Facades\Log;

class PostSeeder extends Seeder
{
    public function run()
    {
        Log::info('Starting seeding for default database');
        try {
            Post::factory()->count(50)->create()->each(function ($post) {
                $tags = Tag::inRandomOrder()->take(3)->pluck('id');
                $post->tags()->attach($tags);
            });
            Log::info('Seeding for default database completed');
        } catch (\Exception $e) {
            Log::error('Error seeding default database:', ['exception' => $e]);
        }

        Log::info('Starting seeding for hai database');
        try {
            Post::on('hai')->factory()->count(50)->create()->each(function ($post) {
                $tags = Tag::on('hai')->inRandomOrder()->take(3)->pluck('id');
                $post->tags()->attach($tags);
            });
            Log::info('Seeding for hai database completed');
        } catch (\Exception $e) {
            Log::error('Error seeding hai database:', ['exception' => $e]);
        }
    }
}
