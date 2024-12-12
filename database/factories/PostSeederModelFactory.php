<?php

namespace Database\Factories;

use App\Models\PostSeederModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostSeederModelFactory extends Factory
{
    protected $model = PostSeederModel::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'body' => $this->faker->paragraph,
            'user_id' => User::factory(),
        ];
    }
}
