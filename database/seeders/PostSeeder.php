<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PostSeederModel;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class PostSeeder extends Seeder
{
    public function run()
    {
        $this->seedShard('default');
        $this->seedShard('hai');
    }

    private function seedShard($shard)
    {
        Log::info("Starting seeding for {$shard} database");
        try {
            User::on($shard)->each(function ($user) use ($shard) {
                // Create multiple posts with random user IDs
                $posts = PostSeederModel::factory()->count(10)->create([
                    'user_id' => User::on($shard)->inRandomOrder()->first()->id
                ]);
                $posts->each(function ($post) use ($shard) {
                    $post->setConnection($shard);
                    $tags = Tag::on($shard)->inRandomOrder()->take(3)->pluck('id');
                    $post->tags()->attach($tags);
                });
            });
            Log::info("Seeding for {$shard} database completed");
        } catch (\Exception $e) {
            Log::error("Error seeding {$shard} database:", ['exception' => $e]);
        }
    }
}
