<?php

namespace App\Http\Requests\Additional;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="ScheduleStoreRequest",
 *     required={"start_date", "end_date", "start_time", "end_time", "technicians", "area_id"},
 *     @OA\Property(
 *         property="start_date",
 *         type="string",
 *         format="date",
 *         example="2024-08-01",
 *         description="Start date of the schedule"
 *     ),
 *     @OA\Property(
 *         property="end_date",
 *         type="string",
 *         format="date",
 *         example="2024-08-01",
 *         description="End date of the schedule"
 *     ),
 *     @OA\Property(
 *         property="start_time",
 *         type="string",
 *         format="time",
 *         example="09:00",
 *         description="Start time of the schedule in HH:mm format"
 *     ),
 *     @OA\Property(
 *         property="end_time",
 *         type="string",
 *         format="time",
 *         example="17:00",
 *         description="End time of the schedule in HH:mm format"
 *     ),
 *     @OA\Property(
 *         property="technicians",
 *         type="array",
 *         @OA\Items(
 *             type="integer",
 *             example=1,
 *             description="ID of the technician"
 *         ),
 *         description="Array of technician IDs"
 *     ),
 *     @OA\Property(
 *         property="area_id",
 *         type="integer",
 *         example=1,
 *         description="ID of the area"
 *     )
 * )
 */
class ScheduleStoreRequest extends FormRequest
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
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'technicians' => 'required|array',
            'technicians.*' => 'exists:users,id',
            'area_id' => 'required|exists:areas,id',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'start_time' => date('H:i', strtotime($this->start_time)),
            'end_time' => date('H:i', strtotime($this->end_time)),
        ]);
    }
}
