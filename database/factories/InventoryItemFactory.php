<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InventoryItem>
 */
class InventoryItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement(['gps_device', 'sim_card', 'accessory', 'cable']);
        
        return [
            'name' => $this->getItemName($type),
            'type' => $type,
            'sku' => strtoupper(fake()->bothify('??###')),
            'serial_number' => fake()->unique()->bothify('SN########'),
            'stock_level' => fake()->numberBetween(0, 100),
            'minimum_stock' => fake()->numberBetween(5, 20),
            'purchase_cost' => fake()->randomFloat(2, 10, 500),
            'selling_price' => fake()->randomFloat(2, 20, 800),
            'vendor' => fake()->company(),
            'vendor_details' => fake()->paragraph(),
            'warranty_months' => fake()->randomElement([6, 12, 24, 36]),
            'warehouse_location' => fake()->bothify('##-?-##'),
            'description' => fake()->paragraph(),
            'status' => fake()->randomElement(['active', 'discontinued', 'out_of_stock']),
        ];
    }

    /**
     * Get item name based on type.
     */
    protected function getItemName(string $type): string
    {
        return match ($type) {
            'gps_device' => 'GPS Tracker ' . fake()->bothify('Model ??###'),
            'sim_card' => 'SIM Card ' . fake()->bothify('??###'),
            'accessory' => fake()->randomElement(['Magnetic Mount', 'Car Charger', 'Antenna', 'Extension Cable']),
            'cable' => fake()->randomElement(['USB Cable', 'Power Cable', 'Extension Cable']),
            default => 'Unknown Item',
        };
    }

    /**
     * Indicate that the item is low stock.
     */
    public function lowStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'stock_level' => fake()->numberBetween(0, 5),
            'minimum_stock' => fake()->numberBetween(5, 10),
        ]);
    }

    /**
     * Indicate that the item is a GPS device.
     */
    public function gpsDevice(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'gps_device',
            'name' => 'GPS Tracker ' . fake()->bothify('Model ??###'),
            'purchase_cost' => fake()->randomFloat(2, 50, 200),
            'selling_price' => fake()->randomFloat(2, 80, 350),
        ]);
    }
}