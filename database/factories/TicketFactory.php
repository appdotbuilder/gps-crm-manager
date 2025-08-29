<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ticket_number' => 'TKT-' . fake()->unique()->numerify('######'),
            'customer_id' => Customer::factory(),
            'subject' => fake()->sentence(6),
            'description' => fake()->paragraph(3),
            'priority' => fake()->randomElement(['low', 'medium', 'high', 'urgent']),
            'status' => fake()->randomElement(['open', 'pending', 'resolved', 'closed']),
            'issue_type' => fake()->randomElement(['technical', 'billing', 'general', 'hardware', 'software']),
            'assigned_to' => User::factory(),
            'resolution_notes' => fake()->paragraph(),
            'resolved_at' => fake()->boolean(60) ? fake()->dateTimeBetween('-30 days', 'now') : null,
        ];
    }

    /**
     * Indicate that the ticket is urgent.
     */
    public function urgent(): static
    {
        return $this->state(fn (array $attributes) => [
            'priority' => 'urgent',
            'status' => 'open',
        ]);
    }

    /**
     * Indicate that the ticket is resolved.
     */
    public function resolved(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'resolved',
            'resolved_at' => fake()->dateTimeBetween('-7 days', 'now'),
        ]);
    }
}