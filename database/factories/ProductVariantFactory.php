<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProductVariant>
 */
class ProductVariantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory()->published()->create()->id,
            'status' => true,
            'price' => rand(80, 90) * 10000,
            'sku' => $this->faker->uuid(),
            'image' => $this->faker->imageUrl(),
            'is_default' => rand(0, 1),
        ];
    }

    public function offer(): static
    {
        return $this->state(fn (array $attributes) => [
            'offer_price' => rand(60, 70) * 10000,
            'offer_end_date' => now()->addDays(rand(1, 30)),
        ]);
    }
}
