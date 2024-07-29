<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="CustomerPhoneRequest",
 *     title="Customer Phone Request",
 *     description="Request schema for creating or updating a customer phone record",
 *     type="object",
 *     required={"phone_number"},
 *     @OA\Property(
 *         property="phone_number",
 *         type="string",
 *         description="The phone number of the customer",
 *         example="+1234567890"
 *     ),
 *     @OA\Property(
 *         property="note",
 *         type="string",
 *         description="Optional note about the phone number",
 *         example="Preferred contact number"
 *     )
 * )
 */
class CustomerPhoneRequest extends FormRequest
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
            'phone_number' => 'required|string|max:255',
            'note' => 'nullable|string|max:255',
        ];
    }
}
