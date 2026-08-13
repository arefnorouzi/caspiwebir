<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Cart>
 */
class CartFactory extends Factory
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
            return [
                'user_id' => User::factory()->create(),
            ];
        }
        else
        {
            $sessionIds = [
                'session_abc123',
                'session_def456',
                'session_ghi789',
            ];
            return [
                'session_id' => array_rand($sessionIds)
            ];
        }

    }

    public function configure(): static
    {
        return $this->afterCreating(function (Cart $cart) {
            // Create 2-5 invoice items for each invoice
            $items = CartItem::factory()
                ->count(fake()->numberBetween(1, 3))
                ->create(['cart_id' => $cart->id]);

            // Calculate and update the invoice total
            $sub_total = 0;
            $discount = 0;
            foreach ($items as $item) {
                $sub_total += $item->qty * $item->unit_price;
                $discount += $item->qty * intval(max(0, $item->item_price - $item->unit_price));
            }
            $cart->sub_total = $sub_total;
            $cart->discount = $discount;
            $cart->total_amount = $sub_total - $discount;
            $cart->update();
        });
    }
}
