<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class TagService
{
    public function ensureTagExists($tagName)
    {
        if (!DB::table('tags')->where('name', $tagName)->exists()) {
            DB::table('tags')->insert([
                'name' => $tagName,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
