<?php

namespace Database\Factories;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InvoiceItem>
 */
class InvoiceItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $quantity = fake()->numberBetween(1, 10);
        $unitPrice = fake()->randomFloat(2, 10, 500);
        $totalPrice = $quantity * $unitPrice;
        
        return [
            'invoice_id' => Invoice::factory(),
            'description' => fake()->randomElement([
                'GPS Tracking Device',
                'Monthly Service Fee',
                'SIM Card',
                'Installation Service',
                'Setup Fee',
                'Premium Support',
            ]),
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'total_price' => $totalPrice,
            'tax_rate' => fake()->randomElement([0, 5, 10, 15]),
        ];
    }
}