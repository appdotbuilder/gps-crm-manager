<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLeadRequest;
use App\Http\Requests\UpdateLeadRequest;
use App\Models\Lead;
use App\Models\User;
use Inertia\Inertia;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $leads = Lead::with('assignedTo')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $salesReps = User::select('id', 'name')->get();

        return Inertia::render('leads/index', [
            'leads' => $leads,
            'sales_reps' => $salesReps,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $salesReps = User::select('id', 'name')->get();

        return Inertia::render('leads/create', [
            'sales_reps' => $salesReps,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLeadRequest $request)
    {
        $lead = Lead::create($request->validated());

        return redirect()->route('leads.show', $lead)
            ->with('success', 'Lead created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lead $lead)
    {
        $lead->load('assignedTo', 'tasks.assignee');

        return Inertia::render('leads/show', [
            'lead' => $lead,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lead $lead)
    {
        $salesReps = User::select('id', 'name')->get();

        return Inertia::render('leads/edit', [
            'lead' => $lead,
            'sales_reps' => $salesReps,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLeadRequest $request, Lead $lead)
    {
        $lead->update($request->validated());

        return redirect()->route('leads.show', $lead)
            ->with('success', 'Lead updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lead $lead)
    {
        $lead->delete();

        return redirect()->route('leads.index')
            ->with('success', 'Lead deleted successfully.');
    }
}