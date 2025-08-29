<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;
use App\Models\User;
use Inertia\Inertia;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::with('accountManager')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $accountManagers = User::select('id', 'name')->get();

        return Inertia::render('customers/index', [
            'customers' => $customers,
            'account_managers' => $accountManagers,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $accountManagers = User::select('id', 'name')->get();

        return Inertia::render('customers/create', [
            'account_managers' => $accountManagers,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        $customer = Customer::create($request->validated());

        return redirect()->route('customers.show', $customer)
            ->with('success', 'Customer created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        $customer->load([
            'accountManager',
            'invoices' => function ($query) {
                $query->latest()->limit(10);
            },
            'tickets' => function ($query) {
                $query->latest()->limit(10);
            },
            'tasks.assignee',
        ]);

        return Inertia::render('customers/show', [
            'customer' => $customer,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        $accountManagers = User::select('id', 'name')->get();

        return Inertia::render('customers/edit', [
            'customer' => $customer,
            'account_managers' => $accountManagers,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $customer->update($request->validated());

        return redirect()->route('customers.show', $customer)
            ->with('success', 'Customer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customers.index')
            ->with('success', 'Customer deleted successfully.');
    }
}