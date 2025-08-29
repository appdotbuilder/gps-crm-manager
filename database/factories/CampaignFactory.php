<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Campaign>
 */
class CampaignFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement(['email', 'sms']);
        
        return [
            'name' => fake()->sentence(3),
            'type' => $type,
            'template' => $this->getTemplate($type),
            'segmentation_criteria' => [
                'service_plan' => fake()->randomElement(['basic', 'standard', 'premium']),
                'status' => 'active',
            ],
            'status' => fake()->randomElement(['draft', 'scheduled', 'sent', 'cancelled']),
            'scheduled_at' => fake()->dateTimeBetween('now', '+7 days'),
            'sent_at' => fake()->boolean(40) ? fake()->dateTimeBetween('-7 days', 'now') : null,
            'recipient_count' => fake()->numberBetween(50, 500),
            'delivered_count' => fake()->numberBetween(45, 480),
            'opened_count' => fake()->numberBetween(20, 200),
            'clicked_count' => fake()->numberBetween(5, 50),
            'created_by' => User::factory(),
        ];
    }

    /**
     * Get template based on campaign type.
     */
    protected function getTemplate(string $type): string
    {
        if ($type === 'email') {
            return 'Hello {CustomerName}, your GPS tracking service is working perfectly! You have {DeviceCount} devices active.';
        }
        
        return 'Hi {CustomerName}, reminder: Your invoice #{InvoiceNumber} is due on {InvoiceDueDate}. Pay now to avoid service interruption.';
    }

    /**
     * Indicate that the campaign is sent.
     */
    public function sent(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'sent',
            'sent_at' => fake()->dateTimeBetween('-7 days', 'now'),
        ]);
    }
}