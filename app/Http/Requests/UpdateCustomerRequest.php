<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,' . $this->route('customer')->id . '|max:255',
            'phone' => 'nullable|string|max:50',
            'company' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'device_count' => 'required|integer|min:0|max:10000',
            'service_plan' => 'required|in:basic,standard,premium,enterprise',
            'contract_start_date' => 'nullable|date',
            'contract_end_date' => 'nullable|date|after:contract_start_date',
            'contract_terms' => 'nullable|string',
            'account_manager_id' => 'nullable|exists:users,id',
            'billing_address' => 'nullable|string',
            'billing_email' => 'nullable|email|max:255',
            'status' => 'required|in:active,inactive,suspended',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Customer name is required.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email is already registered to another customer.',
            'device_count.required' => 'Device count is required.',
            'device_count.integer' => 'Device count must be a valid number.',
            'device_count.min' => 'Device count cannot be negative.',
            'service_plan.required' => 'Service plan is required.',
            'service_plan.in' => 'Invalid service plan selected.',
            'contract_end_date.after' => 'Contract end date must be after start date.',
            'account_manager_id.exists' => 'Selected account manager does not exist.',
            'status.required' => 'Customer status is required.',
            'status.in' => 'Invalid customer status selected.',
        ];
    }
}