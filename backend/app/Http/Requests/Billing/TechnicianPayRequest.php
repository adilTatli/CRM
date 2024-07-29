<?php

namespace App\Http\Requests\Billing;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="TechnicianPayRequest",
 *     type="object",
 *     required={"payment_status"},
 *     @OA\Property(
 *         property="payment_amount",
 *         type="number",
 *         format="float",
 *         description="Amount paid to the technician",
 *         example=150.50
 *     ),
 *     @OA\Property(
 *         property="paid_at",
 *         type="string",
 *         format="date-time",
 *         description="Date and time when payment was made",
 *         example="2024-07-28T14:00:00Z"
 *     ),
 *     @OA\Property(
 *         property="payment_status",
 *         type="string",
 *         description="Status of the payment",
 *         enum={"paid", "not paid"},
 *         example="paid"
 *     )
 * )
 */
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
