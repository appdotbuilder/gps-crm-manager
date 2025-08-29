<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
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
            'address' => fake()->address(),
            'device_count' => fake()->numberBetween(1, 50),
            'service_plan' => fake()->randomElement(['basic', 'standard', 'premium', 'enterprise']),
            'contract_start_date' => fake()->dateTimeBetween('-2 years', 'now'),
            'contract_end_date' => fake()->dateTimeBetween('now', '+2 years'),
            'contract_terms' => fake()->paragraph(),
            'account_manager_id' => User::factory(),
            'billing_address' => fake()->address(),
            'billing_email' => fake()->safeEmail(),
            'status' => fake()->randomElement(['active', 'inactive', 'suspended']),
        ];
    }

    /**
     * Indicate that the customer is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
        ]);
    }

    /**
     * Indicate that the customer is premium.
     */
    public function premium(): static
    {
        return $this->state(fn (array $attributes) => [
            'service_plan' => 'premium',
            'device_count' => fake()->numberBetween(20, 100),
        ]);
    }
}