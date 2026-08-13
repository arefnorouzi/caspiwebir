<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'slug' => $this->faker->slug(),
            'description' => $this->faker->realText(),
            'meta' => $this->faker->sentence(),
            'user_id' => 1,
            'published_by' => 1,
            'status' => rand(0, 1),
            'pinned' => rand(0, 1),
            'blog_category_id' => rand(1, 5),
            'published_at' => now()->subDays(rand(1, 30)),
        ];
    }
}
