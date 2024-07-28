<?php

namespace App\Http\Requests\Billing;

use Illuminate\Foundation\Http\FormRequest;

class TechnicianPayRequest extends FormRequest
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
            'payment_amount' => 'nullable|numeric',
            'paid_at' => 'nullable|date',
            'payment_status' => 'nullable|in:paid,not paid',
        ];
    }

    public function messages()
    {
        return [
            'payment_amount.numeric' => 'The payment amount must be a number.',
            'paid_at.date' => 'The paid date must be a valid date.',
            'payment_status.in' => 'The payment status must be either "paid" or "not paid".',
        ];
    }
}
