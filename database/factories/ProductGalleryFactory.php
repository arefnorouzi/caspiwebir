<?php

namespace Database\Factories;

use App\Models\ProductGallery;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProductGallery>
 */
class ProductGalleryFactory extends Factory
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
            'image' => '/images/products/' . rand(1, 20) . '.webp'
        ];
    }
}
