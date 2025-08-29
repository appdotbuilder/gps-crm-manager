<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lead>
 */
class LeadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'company' => fake()->company(),
            'source' => fake()->randomElement(['website', 'referral', 'cold_call', 'social_media', 'trade_show', 'other']),
            'status' => fake()->randomElement(['new', 'contacted', 'qualified', 'lost']),
            'notes' => fake()->paragraph(),
            'assigned_to' => User::factory(),
            'next_followup_at' => fake()->dateTimeBetween('now', '+30 days'),
            'potential_value' => fake()->randomFloat(2, 1000, 50000),
        ];
    }

    /**
     * Indicate that the lead is new.
     */
    public function newStatus(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'new',
            'next_followup_at' => fake()->dateTimeBetween('now', '+7 days'),
        ]);
    }

    /**
     * Indicate that the lead is qualified.
     */
    public function qualified(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'qualified',
            'potential_value' => fake()->randomFloat(2, 10000, 100000),
        ]);
    }
}