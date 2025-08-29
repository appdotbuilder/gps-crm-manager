<?php

namespace Database\Seeders;

use App\Models\Campaign;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\InventoryItem;
use App\Models\Lead;
use App\Models\Payment;
use App\Models\Task;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Seeder;

class GpsTrackingSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create users with different roles
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@gpstrackpro.com',
        ]);

        $salesRep1 = User::factory()->create([
            'name' => 'John Sales',
            'email' => 'john@gpstrackpro.com',
        ]);

        $salesRep2 = User::factory()->create([
            'name' => 'Sarah Manager',
            'email' => 'sarah@gpstrackpro.com',
        ]);

        $supportAgent = User::factory()->create([
            'name' => 'Mike Support',
            'email' => 'mike@gpstrackpro.com',
        ]);

        // Create leads
        Lead::factory(25)->create([
            'assigned_to' => fake()->randomElement([$salesRep1->id, $salesRep2->id]),
        ]);

        Lead::factory(10)->qualified()->create([
            'assigned_to' => $salesRep1->id,
        ]);

        Lead::factory(15)->newStatus()->create([
            'assigned_to' => $salesRep2->id,
        ]);

        // Create customers
        $customers = collect();
        
        // Premium customers
        $premiumCustomers = Customer::factory(5)->premium()->create([
            'account_manager_id' => $salesRep1->id,
        ]);
        $customers = $customers->merge($premiumCustomers);

        // Regular customers
        $regularCustomers = Customer::factory(20)->active()->create([
            'account_manager_id' => fake()->randomElement([$salesRep1->id, $salesRep2->id]),
        ]);
        $customers = $customers->merge($regularCustomers);

        // Some inactive customers
        Customer::factory(5)->create([
            'status' => 'inactive',
            'account_manager_id' => $salesRep2->id,
        ]);

        // Create inventory items
        InventoryItem::factory(15)->gpsDevice()->create();
        InventoryItem::factory(10)->create(['type' => 'sim_card']);
        InventoryItem::factory(8)->create(['type' => 'accessory']);
        InventoryItem::factory(5)->create(['type' => 'cable']);
        InventoryItem::factory(3)->lowStock()->create();

        // Create invoices and related data for customers
        $customers->take(15)->each(function ($customer) {
            // Create 2-4 invoices per customer
            $invoiceCount = fake()->numberBetween(2, 4);
            
            for ($i = 0; $i < $invoiceCount; $i++) {
                $invoice = Invoice::factory()->create([
                    'customer_id' => $customer->id,
                ]);

                // Create 1-3 invoice items per invoice
                $itemCount = fake()->numberBetween(1, 3);
                for ($j = 0; $j < $itemCount; $j++) {
                    InvoiceItem::factory()->create([
                        'invoice_id' => $invoice->id,
                    ]);
                }

                // Create payment for some invoices
                if (fake()->boolean(70)) {
                    Payment::factory()->completed()->create([
                        'invoice_id' => $invoice->id,
                        'customer_id' => $customer->id,
                        'amount' => $invoice->total_amount,
                    ]);

                    $invoice->update(['status' => 'paid']);
                }
            }
        });

        // Create some overdue invoices
        Invoice::factory(8)->overdue()->create();

        // Create tickets
        $customers->take(12)->each(function ($customer) use ($supportAgent) {
            Ticket::factory(fake()->numberBetween(1, 3))->create([
                'customer_id' => $customer->id,
                'assigned_to' => $supportAgent->id,
            ]);
        });

        // Create urgent tickets
        Ticket::factory(5)->urgent()->create([
            'assigned_to' => $supportAgent->id,
        ]);

        // Create tasks
        Task::factory(10)->forLead()->create([
            'assignee_id' => $salesRep1->id,
            'created_by' => $admin->id,
        ]);

        Task::factory(8)->forCustomer()->create([
            'assignee_id' => $salesRep2->id,
            'created_by' => $admin->id,
        ]);

        Task::factory(5)->create([
            'assignee_id' => $supportAgent->id,
            'created_by' => $admin->id,
            'status' => 'open',
            'due_date' => fake()->dateTimeBetween('-5 days', 'now'), // Overdue tasks
        ]);

        // Create campaigns
        Campaign::factory(3)->sent()->create([
            'created_by' => $admin->id,
        ]);

        Campaign::factory(2)->create([
            'created_by' => $salesRep1->id,
            'status' => 'draft',
        ]);

        $this->command->info('GPS Tracking System seeded successfully!');
        $this->command->info('Sample users created:');
        $this->command->info('- Admin: admin@gpstrackpro.com (password: password)');
        $this->command->info('- Sales Rep: john@gpstrackpro.com (password: password)');
        $this->command->info('- Account Manager: sarah@gpstrackpro.com (password: password)');
        $this->command->info('- Support Agent: mike@gpstrackpro.com (password: password)');
    }
}