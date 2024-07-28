<?php

namespace App\Http\Requests\Billing;

use Illuminate\Foundation\Http\FormRequest;

class ReceivedPaymentRequest extends FormRequest
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
            'task_id' => 'required|exists:tasks,id',
            'payment' => 'required|numeric|min:0',
            'payment_status' => 'required|in:check,cash,credit card,eft,warranty,other',
            'pay_doc' => 'nullable|string|max:255',
            'date_received' => 'required|date',
            'notes' => 'nullable|string',
        ];
    }
}
