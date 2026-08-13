<?php

namespace Database\Factories;

use App\Models\ProductFeature;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProductFeature>
 */
class ProductFeatureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->company,
            'image' => '/icons/star.svg',
            'pinned' => rand(0, 1),
        ];
    }
}
