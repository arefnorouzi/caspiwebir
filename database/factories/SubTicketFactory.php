<?php

namespace Database\Factories;

use App\Models\SubTicket;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SubTicket>
 */
class SubTicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $support_id = null;
        $user_id = null;
        if (rand(0, 1)) {
            $support_id = rand(1, 2);
        }
        else{
            $user_id = rand(3, 30);
        }
        return [
            'user_id' => $user_id,
            'support_id' => $support_id,
            'description' => fake()->sentence(),
            'created_at' => now()->subHours(rand(1, 120)),
        ];
    }
}
