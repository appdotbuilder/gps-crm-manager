import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/react';

interface DashboardStats {
    leads: {
        total: number;
        new: number;
        qualified: number;
        contacted: number;
    };
    customers: {
        total: number;
        active: number;
        new_this_month: number;
    };
    invoices: {
        total_revenue: number;
        overdue_count: number;
        overdue_amount: number;
        pending_count: number;
    };
    tickets: {
        open: number;
        urgent: number;
        pending: number;
    };
    tasks: {
        overdue: number;
        due_today: number;
        in_progress: number;
    };
    inventory_alerts: number;
}

interface RecentData {
    leads: Array<{
        id: number;
        name: string;
        company: string | null;
        status: string;
        assigned_to: { name: string } | null;
        created_at: string;
    }>;
    customers: Array<{
        id: number;
        name: string;
        company: string | null;
        device_count: number;
        service_plan: string;
        created_at: string;
    }>;
    urgent_tickets: Array<{
        id: number;
        ticket_number: string;
        subject: string;
        priority: string;
        customer: { name: string };
        assigned_to: { name: string } | null;
        created_at: string;
    }>;
}

interface Props {
    stats: DashboardStats;
    recent: RecentData;
    [key: string]: unknown;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

export default function Dashboard({ stats, recent }: Props) {
    const formatCurrency = (amount: number) => {
        return new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD',
        }).format(amount);
    };

    const getStatusColor = (status: string, type: 'lead' | 'customer' | 'ticket' | 'priority') => {
        if (type === 'lead') {
            switch (status) {
                case 'new': return 'bg-blue-100 text-blue-800';
                case 'contacted': return 'bg-yellow-100 text-yellow-800';
                case 'qualified': return 'bg-green-100 text-green-800';
                case 'lost': return 'bg-red-100 text-red-800';
                default: return 'bg-gray-100 text-gray-800';
            }
        }
        if (type === 'customer') {
            switch (status) {
                case 'active': return 'bg-green-100 text-green-800';
                case 'inactive': return 'bg-gray-100 text-gray-800';
                case 'suspended': return 'bg-red-100 text-red-800';
                default: return 'bg-gray-100 text-gray-800';
            }
        }
        if (type === 'ticket') {
            switch (status) {
                case 'open': return 'bg-blue-100 text-blue-800';
                case 'pending': return 'bg-yellow-100 text-yellow-800';
                case 'resolved': return 'bg-green-100 text-green-800';
                case 'closed': return 'bg-gray-100 text-gray-800';
                default: return 'bg-gray-100 text-gray-800';
            }
        }
        if (type === 'priority') {
            switch (status) {
                case 'low': return 'bg-gray-100 text-gray-800';
                case 'medium': return 'bg-yellow-100 text-yellow-800';
                case 'high': return 'bg-orange-100 text-orange-800';
                case 'urgent': return 'bg-red-100 text-red-800';
                default: return 'bg-gray-100 text-gray-800';
            }
        }
        return 'bg-gray-100 text-gray-800';
    };

    const getPlanColor = (plan: string) => {
        switch (plan) {
            case 'basic': return 'bg-gray-100 text-gray-800';
            case 'standard': return 'bg-blue-100 text-blue-800';
            case 'premium': return 'bg-purple-100 text-purple-800';
            case 'enterprise': return 'bg-yellow-100 text-yellow-800';
            default: return 'bg-gray-100 text-gray-800';
        }
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="GPS Tracking Business Dashboard" />
            <div className="flex h-full flex-1 flex-col gap-6 rounded-xl p-6 overflow-x-auto">
                {/* Welcome Section */}
                <div className="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg p-6 text-white">
                    <h1 className="text-2xl font-bold mb-2">🛰️ GPS Tracking Business Dashboard</h1>
                    <p className="text-blue-100">Welcome to your comprehensive business management system</p>
                </div>

                {/* Key Metrics Grid */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    {/* Lead Metrics */}
                    <div className="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-gray-600">Total Leads</p>
                                <p className="text-3xl font-bold text-gray-900">{stats.leads.total}</p>
                            </div>
                            <div className="text-3xl">👥</div>
                        </div>
                        <div className="mt-4 flex gap-4 text-sm">
                            <span className="text-blue-600">New: {stats.leads.new}</span>
                            <span className="text-green-600">Qualified: {stats.leads.qualified}</span>
                        </div>
                        <Link href="/leads" className="text-sm text-blue-600 hover:underline mt-2 inline-block">
                            View all leads →
                        </Link>
                    </div>

                    {/* Customer Metrics */}
                    <div className="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-gray-600">Active Customers</p>
                                <p className="text-3xl font-bold text-gray-900">{stats.customers.active}</p>
                            </div>
                            <div className="text-3xl">🏢</div>
                        </div>
                        <div className="mt-4 text-sm">
                            <span className="text-green-600">New this month: {stats.customers.new_this_month}</span>
                        </div>
                        <Link href="/customers" className="text-sm text-blue-600 hover:underline mt-2 inline-block">
                            View all customers →
                        </Link>
                    </div>

                    {/* Revenue Metrics */}
                    <div className="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-gray-600">Total Revenue</p>
                                <p className="text-3xl font-bold text-gray-900">{formatCurrency(stats.invoices.total_revenue)}</p>
                            </div>
                            <div className="text-3xl">💰</div>
                        </div>
                        <div className="mt-4 text-sm">
                            <span className="text-red-600">Overdue: {formatCurrency(stats.invoices.overdue_amount)}</span>
                        </div>
                        <Link href="/invoices" className="text-sm text-blue-600 hover:underline mt-2 inline-block">
                            View invoices →
                        </Link>
                    </div>

                    {/* Support Metrics */}
                    <div className="bg-white rounded-lg shadow-md p-6 border-l-4 border-red-500">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-gray-600">Open Tickets</p>
                                <p className="text-3xl font-bold text-gray-900">{stats.tickets.open}</p>
                            </div>
                            <div className="text-3xl">🎫</div>
                        </div>
                        <div className="mt-4 text-sm">
                            <span className="text-red-600">Urgent: {stats.tickets.urgent}</span>
                        </div>
                        <Link href="/tickets" className="text-sm text-blue-600 hover:underline mt-2 inline-block">
                            View tickets →
                        </Link>
                    </div>
                </div>

                {/* Alert Cards */}
                <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                    {stats.tasks.overdue > 0 && (
                        <div className="bg-red-50 border border-red-200 rounded-lg p-4">
                            <div className="flex items-center">
                                <div className="text-red-500 text-xl mr-3">⚠️</div>
                                <div>
                                    <h3 className="font-medium text-red-800">Overdue Tasks</h3>
                                    <p className="text-sm text-red-600">{stats.tasks.overdue} tasks need attention</p>
                                </div>
                            </div>
                        </div>
                    )}

                    {stats.inventory_alerts > 0 && (
                        <div className="bg-orange-50 border border-orange-200 rounded-lg p-4">
                            <div className="flex items-center">
                                <div className="text-orange-500 text-xl mr-3">📦</div>
                                <div>
                                    <h3 className="font-medium text-orange-800">Low Stock Alert</h3>
                                    <p className="text-sm text-orange-600">{stats.inventory_alerts} items need restocking</p>
                                </div>
                            </div>
                        </div>
                    )}

                    {stats.invoices.overdue_count > 0 && (
                        <div className="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <div className="flex items-center">
                                <div className="text-yellow-500 text-xl mr-3">💳</div>
                                <div>
                                    <h3 className="font-medium text-yellow-800">Overdue Invoices</h3>
                                    <p className="text-sm text-yellow-600">{stats.invoices.overdue_count} invoices overdue</p>
                                </div>
                            </div>
                        </div>
                    )}
                </div>

                {/* Recent Activity */}
                <div className="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                    {/* Recent Leads */}
                    <div className="bg-white rounded-lg shadow-md p-6">
                        <h3 className="text-lg font-semibold mb-4 flex items-center">
                            <span className="text-xl mr-2">👥</span>
                            Recent Leads
                        </h3>
                        <div className="space-y-3">
                            {recent.leads.map((lead) => (
                                <div key={lead.id} className="flex items-center justify-between py-2 border-b border-gray-100 last:border-b-0">
                                    <div className="flex-1 min-w-0">
                                        <p className="text-sm font-medium text-gray-900 truncate">{lead.name}</p>
                                        <p className="text-sm text-gray-500 truncate">{lead.company || 'No company'}</p>
                                    </div>
                                    <div className="flex flex-col items-end gap-1">
                                        <span className={`inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${getStatusColor(lead.status, 'lead')}`}>
                                            {lead.status}
                                        </span>
                                        <span className="text-xs text-gray-400">
                                            {new Date(lead.created_at).toLocaleDateString()}
                                        </span>
                                    </div>
                                </div>
                            ))}
                        </div>
                        <Link href="/leads" className="text-sm text-blue-600 hover:underline mt-4 inline-block">
                            View all leads →
                        </Link>
                    </div>

                    {/* Recent Customers */}
                    <div className="bg-white rounded-lg shadow-md p-6">
                        <h3 className="text-lg font-semibold mb-4 flex items-center">
                            <span className="text-xl mr-2">🏢</span>
                            Recent Customers
                        </h3>
                        <div className="space-y-3">
                            {recent.customers.map((customer) => (
                                <div key={customer.id} className="flex items-center justify-between py-2 border-b border-gray-100 last:border-b-0">
                                    <div className="flex-1 min-w-0">
                                        <p className="text-sm font-medium text-gray-900 truncate">{customer.name}</p>
                                        <p className="text-sm text-gray-500 truncate">{customer.device_count} devices</p>
                                    </div>
                                    <div className="flex flex-col items-end gap-1">
                                        <span className={`inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${getPlanColor(customer.service_plan)}`}>
                                            {customer.service_plan}
                                        </span>
                                        <span className="text-xs text-gray-400">
                                            {new Date(customer.created_at).toLocaleDateString()}
                                        </span>
                                    </div>
                                </div>
                            ))}
                        </div>
                        <Link href="/customers" className="text-sm text-blue-600 hover:underline mt-4 inline-block">
                            View all customers →
                        </Link>
                    </div>

                    {/* Urgent Tickets */}
                    <div className="bg-white rounded-lg shadow-md p-6">
                        <h3 className="text-lg font-semibold mb-4 flex items-center">
                            <span className="text-xl mr-2">🚨</span>
                            Urgent Tickets
                        </h3>
                        <div className="space-y-3">
                            {recent.urgent_tickets.map((ticket) => (
                                <div key={ticket.id} className="py-2 border-b border-gray-100 last:border-b-0">
                                    <div className="flex items-center justify-between mb-1">
                                        <p className="text-sm font-medium text-gray-900 truncate">{ticket.ticket_number}</p>
                                        <span className={`inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${getStatusColor(ticket.priority, 'priority')}`}>
                                            {ticket.priority}
                                        </span>
                                    </div>
                                    <p className="text-sm text-gray-600 truncate">{ticket.subject}</p>
                                    <p className="text-xs text-gray-400 mt-1">{ticket.customer.name}</p>
                                </div>
                            ))}
                        </div>
                        <Link href="/tickets" className="text-sm text-blue-600 hover:underline mt-4 inline-block">
                            View all tickets →
                        </Link>
                    </div>
                </div>

                {/* Quick Actions */}
                <div className="bg-white rounded-lg shadow-md p-6">
                    <h3 className="text-lg font-semibold mb-4">⚡ Quick Actions</h3>
                    <div className="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                        <Link href="/leads/create" className="flex flex-col items-center p-3 rounded-lg border-2 border-dashed border-gray-300 hover:border-blue-500 hover:bg-blue-50 transition-colors">
                            <span className="text-2xl mb-2">👤</span>
                            <span className="text-sm font-medium">Add Lead</span>
                        </Link>
                        <Link href="/customers/create" className="flex flex-col items-center p-3 rounded-lg border-2 border-dashed border-gray-300 hover:border-green-500 hover:bg-green-50 transition-colors">
                            <span className="text-2xl mb-2">🏢</span>
                            <span className="text-sm font-medium">Add Customer</span>
                        </Link>
                        <Link href="/invoices/create" className="flex flex-col items-center p-3 rounded-lg border-2 border-dashed border-gray-300 hover:border-yellow-500 hover:bg-yellow-50 transition-colors">
                            <span className="text-2xl mb-2">📄</span>
                            <span className="text-sm font-medium">Create Invoice</span>
                        </Link>
                        <Link href="/inventory" className="flex flex-col items-center p-3 rounded-lg border-2 border-dashed border-gray-300 hover:border-purple-500 hover:bg-purple-50 transition-colors">
                            <span className="text-2xl mb-2">📦</span>
                            <span className="text-sm font-medium">Check Inventory</span>
                        </Link>
                        <Link href="/tickets/create" className="flex flex-col items-center p-3 rounded-lg border-2 border-dashed border-gray-300 hover:border-red-500 hover:bg-red-50 transition-colors">
                            <span className="text-2xl mb-2">🎫</span>
                            <span className="text-sm font-medium">New Ticket</span>
                        </Link>
                        <Link href="/campaigns/create" className="flex flex-col items-center p-3 rounded-lg border-2 border-dashed border-gray-300 hover:border-indigo-500 hover:bg-indigo-50 transition-colors">
                            <span className="text-2xl mb-2">📱</span>
                            <span className="text-sm font-medium">Send Campaign</span>
                        </Link>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}