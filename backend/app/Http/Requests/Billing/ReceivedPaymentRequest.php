<?php

namespace App\Http\Requests\Billing;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ReceivedPaymentRequest
 *
 * @OA\Schema(
 *     description="Request payload for creating or updating a received payment.",
 *     type="object",
 *     title="ReceivedPaymentRequest",
 *     required={"task_id", "payment", "payment_status", "date_received"},
 *     @OA\Property(
 *         property="task_id",
 *         type="integer",
 *         description="ID of the task related to this payment.",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="payment",
 *         type="number",
 *         format="float",
 *         description="Amount of the payment.",
 *         example=100.50
 *     ),
 *     @OA\Property(
 *         property="payment_status",
 *         type="string",
 *         description="Status of the payment.",
 *         enum={"check", "cash", "credit card", "eft", "warranty", "other"},
 *         example="cash"
 *     ),
 *     @OA\Property(
 *         property="pay_doc",
 *         type="string",
 *         description="Document number related to the payment.",
 *         nullable=true,
 *         example="12345"
 *     ),
 *     @OA\Property(
 *         property="date_received",
 *         type="string",
 *         format="date",
 *         description="Date when the payment was received.",
 *         example="2024-07-28"
 *     ),
 *     @OA\Property(
 *         property="notes",
 *         type="string",
 *         description="Additional notes about the payment.",
 *         nullable=true,
 *         example="Payment received in full."
 *     )
 * )
 */
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
