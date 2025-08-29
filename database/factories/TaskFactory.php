<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $taskableType = fake()->randomElement([Lead::class, Customer::class]);
        
        return [
            'title' => fake()->sentence(4),
            'description' => fake()->paragraph(),
            'priority' => fake()->randomElement(['low', 'medium', 'high']),
            'status' => fake()->randomElement(['open', 'in_progress', 'done']),
            'due_date' => fake()->dateTimeBetween('now', '+30 days'),
            'assignee_id' => User::factory(),
            'created_by' => User::factory(),
            'taskable_type' => $taskableType,
            'taskable_id' => $taskableType::factory(),
        ];
    }

    /**
     * Indicate that the task is for a lead.
     */
    public function forLead(): static
    {
        return $this->state(fn (array $attributes) => [
            'taskable_type' => Lead::class,
            'taskable_id' => Lead::factory(),
            'title' => 'Follow up with lead: ' . fake()->sentence(3),
        ]);
    }

    /**
     * Indicate that the task is for a customer.
     */
    public function forCustomer(): static
    {
        return $this->state(fn (array $attributes) => [
            'taskable_type' => Customer::class,
            'taskable_id' => Customer::factory(),
            'title' => 'Customer service: ' . fake()->sentence(3),
        ]);
    }
}