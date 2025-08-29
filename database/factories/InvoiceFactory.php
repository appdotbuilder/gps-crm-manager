<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
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
        $subtotal = fake()->randomFloat(2, 100, 5000);
        $taxAmount = $subtotal * 0.1; // 10% tax
        $discountAmount = fake()->randomFloat(2, 0, $subtotal * 0.2);
        $totalAmount = $subtotal + $taxAmount - $discountAmount;
        
        return [
            'invoice_number' => 'INV-' . fake()->unique()->numerify('######'),
            'customer_id' => Customer::factory(),
            'invoice_date' => fake()->dateTimeBetween('-6 months', 'now'),
            'due_date' => fake()->dateTimeBetween('now', '+30 days'),
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'discount_amount' => $discountAmount,
            'total_amount' => $totalAmount,
            'status' => fake()->randomElement(['draft', 'sent', 'paid', 'overdue', 'cancelled']),
            'payment_terms' => fake()->randomElement(['net_15', 'net_30', 'due_on_receipt']),
            'notes' => fake()->paragraph(),
            'is_recurring' => fake()->boolean(30),
            'recurring_frequency' => fake()->randomElement(['monthly', 'quarterly', 'yearly']),
            'recurring_start_date' => fake()->dateTimeBetween('now', '+30 days'),
            'recurring_end_date' => fake()->dateTimeBetween('+1 year', '+3 years'),
        ];
    }

    /**
     * Indicate that the invoice is overdue.
     */
    public function overdue(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'overdue',
            'due_date' => fake()->dateTimeBetween('-30 days', '-1 day'),
        ]);
    }

    /**
     * Indicate that the invoice is recurring.
     */
    public function recurring(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_recurring' => true,
            'recurring_frequency' => 'monthly',
        ]);
    }
}