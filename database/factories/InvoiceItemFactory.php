<?php

namespace Database\Factories;

use App\Models\InvoiceItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<InvoiceItem>
 */
class InvoiceItemFactory extends Factory
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
        $discount = $product->price - $product->active_price;
        $total = $quantity * $product->active_price;

        return [
            'product_id' => $product->id,
            'name' => $product->name,
            'qty' => $quantity,
            'unit_price' => $product->active_price,
            'item_price' => $product->price,
            'discount' => $discount,
            'seller_commission' => 0.6,
            'seller_earning' => $total * 0.6,
        ];
    }
}
