<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Lead;
use App\Models\Ticket;
use App\Models\Task;
use App\Models\InventoryItem;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with key metrics.
     */
    public function index()
    {
        // Lead statistics
        $leadStats = [
            'total' => Lead::count(),
            'new' => Lead::where('status', 'new')->count(),
            'qualified' => Lead::where('status', 'qualified')->count(),
            'contacted' => Lead::where('status', 'contacted')->count(),
        ];

        // Customer statistics
        $customerStats = [
            'total' => Customer::count(),
            'active' => Customer::where('status', 'active')->count(),
            'new_this_month' => Customer::whereMonth('created_at', now()->month)->count(),
        ];

        // Invoice statistics
        $invoiceStats = [
            'total_revenue' => Invoice::where('status', 'paid')->sum('total_amount'),
            'overdue_count' => Invoice::overdue()->count(),
            'overdue_amount' => Invoice::overdue()->sum('total_amount'),
            'pending_count' => Invoice::where('status', 'sent')->count(),
        ];

        // Ticket statistics
        $ticketStats = [
            'open' => Ticket::where('status', 'open')->count(),
            'urgent' => Ticket::where('priority', 'urgent')->where('status', '!=', 'closed')->count(),
            'pending' => Ticket::where('status', 'pending')->count(),
        ];

        // Task statistics
        $taskStats = [
            'overdue' => Task::where('due_date', '<', now())->where('status', '!=', 'done')->count(),
            'due_today' => Task::whereDate('due_date', today())->where('status', '!=', 'done')->count(),
            'in_progress' => Task::where('status', 'in_progress')->count(),
        ];

        // Inventory alerts
        $inventoryAlerts = InventoryItem::lowStock()->count();

        // Recent activities
        $recentLeads = Lead::with('assignedTo')->latest()->limit(5)->get();
        $recentCustomers = Customer::with('accountManager')->latest()->limit(5)->get();
        $urgentTickets = Ticket::with('customer', 'assignedTo')
            ->where('priority', 'urgent')
            ->where('status', '!=', 'closed')
            ->latest()
            ->limit(5)
            ->get();

        return Inertia::render('dashboard', [
            'stats' => [
                'leads' => $leadStats,
                'customers' => $customerStats,
                'invoices' => $invoiceStats,
                'tickets' => $ticketStats,
                'tasks' => $taskStats,
                'inventory_alerts' => $inventoryAlerts,
            ],
            'recent' => [
                'leads' => $recentLeads,
                'customers' => $recentCustomers,
                'urgent_tickets' => $urgentTickets,
            ],
        ]);
    }
}