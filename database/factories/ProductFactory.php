<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductGallery;
use App\Models\ProductProperty;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
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
            'price' => rand(80, 100) * 10000,
            'description' => $this->faker->realText(),
            'meta' => $this->faker->sentence(),
            'sku' => Str::random(10),
            'slug' => fake()->slug,
            'brand_id' => rand(1, 6),
            'duration' => rand(1, 6),
            'course_time' => rand(1, 10) . ' ' . 'ساعت',
            'downloadable' => 1,
            'source' => rand(0, 1),
            'user_id' => 2,
            'image' => '/images/products/'.rand(1, 20).'.webp',
        ];
    }

    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => true,
            'stock' => 1,
            'published_at' => now()
        ]);
    }

    public function offer(): static
    {
        return $this->state(fn (array $attributes) => [
            'offer_price' => rand(60, 75) * 10000,
            'offer_end_date' => now()->addDays(rand(1, 30)),
        ]);
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Product $product) {
            ProductProperty::factory()
                ->count(fake()->numberBetween(3, 7))
                ->create(['product_id' => $product->id]);
            ProductGallery::factory()
                ->count(fake()->numberBetween(1, 5))
                ->create(['product_id' => $product->id]);
        });
    }
}
