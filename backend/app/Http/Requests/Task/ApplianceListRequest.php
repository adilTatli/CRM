<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="ApplianceListRequest",
 *     type="object",
 *     required={"serial_number", "model_number", "brand", "appliance_id"},
 *     @OA\Property(
 *         property="serial_number",
 *         type="string",
 *         description="Serial number of the appliance",
 *         example="SN123456"
 *     ),
 *     @OA\Property(
 *         property="model_number",
 *         type="string",
 *         description="Model number of the appliance",
 *         example="MODEL-XYZ"
 *     ),
 *     @OA\Property(
 *         property="brand",
 *         type="string",
 *         description="Brand of the appliance",
 *         example="BrandName"
 *     ),
 *     @OA\Property(
 *         property="dop",
 *         type="string",
 *         format="date",
 *         description="Date of purchase or installation",
 *         example="2024-07-01"
 *     ),
 *     @OA\Property(
 *         property="appl_note",
 *         type="string",
 *         description="Additional notes about the appliance",
 *         example="This appliance needs regular maintenance."
 *     ),
 *     @OA\Property(
 *         property="appliance_id",
 *         type="integer",
 *         description="ID of the appliance",
 *         example=1
 *     )
 * )
 */
class ApplianceListRequest extends FormRequest
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
            'serial_number' => 'required|string|max:255',
            'model_number' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'dop' => 'nullable|date',
            'appl_note' => 'nullable|string',
            'appliance_id' => 'required|exists:appliances,id',
        ];
    }
}
