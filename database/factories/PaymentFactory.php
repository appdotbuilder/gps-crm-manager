<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'invoice_id' => Invoice::factory(),
            'customer_id' => Customer::factory(),
            'amount' => fake()->randomFloat(2, 50, 2000),
            'payment_method' => fake()->randomElement(['credit_card', 'bank_transfer', 'paypal', 'mobile_money', 'cash']),
            'transaction_id' => fake()->bothify('TXN########'),
            'payment_date' => fake()->dateTimeBetween('-6 months', 'now'),
            'status' => fake()->randomElement(['pending', 'completed', 'failed', 'refunded']),
            'notes' => fake()->sentence(),
        ];
    }

    /**
     * Indicate that the payment is completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
        ]);
    }
}