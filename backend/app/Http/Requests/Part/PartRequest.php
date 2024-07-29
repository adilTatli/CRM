<?php

namespace App\Http\Requests\Part;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="PartRequest",
 *     type="object",
 *     required={"part_number", "task_id", "appliance_id", "distributor_id", "status_id", "qnt", "dealer_price", "retail_price"},
 *     @OA\Property(
 *         property="part_number",
 *         type="string",
 *         maxLength=255,
 *         description="The part number."
 *     ),
 *     @OA\Property(
 *         property="task_id",
 *         type="integer",
 *         description="The ID of the associated task.",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="appliance_id",
 *         type="integer",
 *         description="The ID of the associated appliance.",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="distributor_id",
 *         type="integer",
 *         description="The ID of the distributor.",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="status_id",
 *         type="integer",
 *         description="The ID of the part status.",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="qnt",
 *         type="integer",
 *         minimum=1,
 *         description="The quantity of parts.",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="dealer_price",
 *         type="number",
 *         format="float",
 *         minimum=0,
 *         description="The dealer price of the part.",
 *         example=100.0
 *     ),
 *     @OA\Property(
 *         property="retail_price",
 *         type="number",
 *         format="float",
 *         minimum=0,
 *         description="The retail price of the part.",
 *         example=150.0
 *     ),
 *     @OA\Property(
 *         property="distributor_name",
 *         type="string",
 *         maxLength=255,
 *         description="The name of the distributor (optional).",
 *         nullable=true
 *     ),
 *     @OA\Property(
 *         property="part_description",
 *         type="string",
 *         description="A description of the part (optional).",
 *         nullable=true
 *     ),
 *     @OA\Property(
 *         property="distributor_invoice",
 *         type="string",
 *         description="The distributor's invoice number (optional).",
 *         nullable=true
 *     ),
 *     @OA\Property(
 *         property="eta",
 *         type="string",
 *         format="date",
 *         description="The estimated time of arrival (optional).",
 *         nullable=true,
 *         example="2024-08-01"
 *     )
 * )
 */
class PartRequest extends FormRequest
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
            'part_number' => 'required|string|max:255',
            'task_id' => 'required|exists:tasks,id',
            'appliance_id' => 'required|exists:appliances,id',
            'distributor_id' => 'required|exists:distributors,id',
            'status_id' => 'required|exists:part_statuses,id',
            'qnt' => 'required|integer|min:1',
            'dealer_price' => 'required|numeric|min:0',
            'retail_price' => 'required|numeric|min:0',
            'distributor_name' => 'nullable|string|max:255',
            'part_description' => 'nullable|string',
            'distributor_invoice' => 'nullable|string',
            'eta' => 'nullable|date',
        ];
    }
}
