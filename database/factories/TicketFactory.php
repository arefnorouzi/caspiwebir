<?php

namespace Database\Factories;

use App\Models\SubTicket;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Ticket>
 */
class TicketFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => rand(3, 30),
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'status_id' => rand(1, 4),
            'department_id' => rand(1, 3),
            'assign_to_admin' => rand(0, 1),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Ticket $ticket) {
            SubTicket::factory()
                ->count(fake()->numberBetween(1, 5))
                ->create(['ticket_id' => $ticket->id]);

        });
    }
}
