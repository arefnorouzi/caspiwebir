<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::factory()->create();
        $sub_total = rand(100, 200) * 20000;
        $discount = rand(0, 5) * 10000;
        $shipping_cost = 0;

        return [
            'user_id' => $user->id,
            'confirmed_by_user' => rand(0, 1),
            'payment_status' => rand(0, 1),
            'invoice_status_id' => rand(1, 9),
            'payment_method_id' => rand(1, 8),
            'shipping_method_id' => rand(1, 3),
            'uuid' => fake()->uuid(),
            'customer_name' => $user->name,
            'customer_mobile' => fake()->phoneNumber(),
            'sub_total' => $sub_total,
            'discount' => $discount,
            'shipping_cost' => $shipping_cost,
            'bank_invoice_token' => Str::random(),
            'bank_trans_id' => Str::random(),
            'bank_payment_code' => Str::random(),
            'purchased_at' => now()->subDays(rand(1, 30)),
            'shipped_at' => now()->subDays(rand(1, 30)),
            'expired_at' => now()->subDays(rand(1, 30)),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Invoice $invoice) {
            // Create 2-5 invoice items for each invoice
            $items = InvoiceItem::factory()
                ->count(fake()->numberBetween(1, 3))
                ->create(['invoice_id' => $invoice->id]);

            // Calculate and update the invoice total
            $sub_total = 0;
            $discount = 0;
            foreach ($items as $item) {
                $sub_total += $item->qty * $item->unit_price;
                $discount += $item->discount;
            }
            $tax = rand(0, 1) ? $sub_total * 0.1 : 0;
            $invoice->sub_total = $sub_total;
            $invoice->discount = $discount;
            $invoice->tax = $tax;
            $invoice->amount = $sub_total + $tax - $discount;
            $invoice->update();
        });
    }
}
