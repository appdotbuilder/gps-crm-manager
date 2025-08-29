import { LucideIcon } from 'lucide-react';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavGroup {
    title: string;
    items: NavItem[];
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon | null;
    isActive?: boolean;
}

export interface SharedData {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;
    [key: string]: unknown;
}

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
    [key: string]: unknown; // This allows for additional properties...
}

export interface Lead {
    id: number;
    name: string;
    email: string | null;
    phone: string | null;
    company: string | null;
    source: 'website' | 'referral' | 'cold_call' | 'social_media' | 'trade_show' | 'other';
    status: 'new' | 'contacted' | 'qualified' | 'lost';
    notes: string | null;
    assigned_to: number | null;
    next_followup_at: string | null;
    potential_value: number | null;
    assigned_to_user?: User;
    created_at: string;
    updated_at: string;
}

export interface Customer {
    id: number;
    name: string;
    email: string;
    phone: string | null;
    company: string | null;
    address: string | null;
    device_count: number;
    service_plan: 'basic' | 'standard' | 'premium' | 'enterprise';
    contract_start_date: string | null;
    contract_end_date: string | null;
    contract_terms: string | null;
    account_manager_id: number | null;
    billing_address: string | null;
    billing_email: string | null;
    status: 'active' | 'inactive' | 'suspended';
    account_manager?: User;
    created_at: string;
    updated_at: string;
}

export interface InventoryItem {
    id: number;
    name: string;
    type: 'gps_device' | 'sim_card' | 'accessory' | 'cable';
    sku: string;
    serial_number: string | null;
    stock_level: number;
    minimum_stock: number;
    purchase_cost: number;
    selling_price: number;
    vendor: string | null;
    vendor_details: string | null;
    warranty_months: number | null;
    warehouse_location: string | null;
    description: string | null;
    status: 'active' | 'discontinued' | 'out_of_stock';
    created_at: string;
    updated_at: string;
}

export interface Invoice {
    id: number;
    invoice_number: string;
    customer_id: number;
    invoice_date: string;
    due_date: string;
    subtotal: number;
    tax_amount: number;
    discount_amount: number;
    total_amount: number;
    status: 'draft' | 'sent' | 'paid' | 'overdue' | 'cancelled';
    payment_terms: 'net_15' | 'net_30' | 'due_on_receipt';
    notes: string | null;
    is_recurring: boolean;
    recurring_frequency: 'monthly' | 'quarterly' | 'yearly' | null;
    recurring_start_date: string | null;
    recurring_end_date: string | null;
    customer?: Customer;
    created_at: string;
    updated_at: string;
}

export interface Ticket {
    id: number;
    ticket_number: string;
    customer_id: number;
    subject: string;
    description: string;
    priority: 'low' | 'medium' | 'high' | 'urgent';
    status: 'open' | 'pending' | 'resolved' | 'closed';
    issue_type: 'technical' | 'billing' | 'general' | 'hardware' | 'software';
    assigned_to: number | null;
    resolution_notes: string | null;
    resolved_at: string | null;
    customer?: Customer;
    assigned_to_user?: User;
    created_at: string;
    updated_at: string;
}

export interface Task {
    id: number;
    title: string;
    description: string | null;
    priority: 'low' | 'medium' | 'high';
    status: 'open' | 'in_progress' | 'done';
    due_date: string | null;
    assignee_id: number | null;
    created_by: number;
    taskable_type: string;
    taskable_id: number;
    assignee?: User;
    creator?: User;
    created_at: string;
    updated_at: string;
}

export interface Campaign {
    id: number;
    name: string;
    type: 'email' | 'sms';
    template: string;
    segmentation_criteria: Record<string, unknown> | null;
    status: 'draft' | 'scheduled' | 'sent' | 'cancelled';
    scheduled_at: string | null;
    sent_at: string | null;
    recipient_count: number;
    delivered_count: number;
    opened_count: number;
    clicked_count: number;
    created_by: number;
    creator?: User;
    created_at: string;
    updated_at: string;
}
