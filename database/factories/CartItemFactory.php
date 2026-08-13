<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CartItem>
 */
class CartItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        if (rand(0, 1))
        {
            $product = Product::factory()->published()->create();
        }
        else{
            $product = Product::factory()->published()->offer()->create();
        }
        $quantity = fake()->numberBetween(1, 5);
        $total = $quantity * $product->active_price;
        return [
            'product_id' => $product->id,
            'unit_price' => $product->active_price,
            'item_price' => $product->price,
            'name' => $product->name,
            'qty' => $quantity,
            'seller_commission' => 0.6,
            'seller_earning' => $total * 0.6,
        ];
    }
}
