<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="TaskStoreRequest",
 *     title="Create Task Request",
 *     description="Request schema for creating a new task",
 *     type="object",
 *     required={"work_order", "customer_name", "street", "city", "zip", "insurance_id"},
 *     @OA\Property(
 *         property="work_order",
 *         type="string",
 *         description="Work order number",
 *         example="WO123456"
 *     ),
 *     @OA\Property(
 *         property="customer_name",
 *         type="string",
 *         description="Name of the customer",
 *         example="John Doe"
 *     ),
 *     @OA\Property(
 *         property="street",
 *         type="string",
 *         description="Street address",
 *         example="123 Elm Street"
 *     ),
 *     @OA\Property(
 *         property="city",
 *         type="string",
 *         description="City",
 *         example="Springfield"
 *     ),
 *     @OA\Property(
 *         property="zip",
 *         type="string",
 *         description="Zip code",
 *         example="12345"
 *     ),
 *     @OA\Property(
 *         property="authorization",
 *         type="string",
 *         description="Authorization details (optional)",
 *         example="Authorization for work"
 *     ),
 *     @OA\Property(
 *         property="insurance_id",
 *         type="integer",
 *         description="ID of the associated insurance",
 *         example=1
 *     )
 * )
 */
class TaskStoreRequest extends FormRequest
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
            'work_order' => 'required|string|max:255',
            'customer_name' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'zip' => 'required|string|max:10',
            'authorization' => 'nullable|string',
            'insurance_id' => 'required|exists:insurances,id',
        ];
    }
}
