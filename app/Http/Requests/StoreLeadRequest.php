<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLeadRequest extends FormRequest
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
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'company' => 'nullable|string|max:255',
            'source' => 'required|in:website,referral,cold_call,social_media,trade_show,other',
            'status' => 'required|in:new,contacted,qualified,lost',
            'notes' => 'nullable|string',
            'assigned_to' => 'nullable|exists:users,id',
            'next_followup_at' => 'nullable|date|after:now',
            'potential_value' => 'nullable|numeric|min:0|max:999999.99',
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
            'name.required' => 'Lead name is required.',
            'email.email' => 'Please provide a valid email address.',
            'source.required' => 'Lead source is required.',
            'source.in' => 'Invalid lead source selected.',
            'status.required' => 'Lead status is required.',
            'status.in' => 'Invalid lead status selected.',
            'assigned_to.exists' => 'Selected sales representative does not exist.',
            'next_followup_at.after' => 'Follow-up date must be in the future.',
            'potential_value.numeric' => 'Potential value must be a valid number.',
        ];
    }
}