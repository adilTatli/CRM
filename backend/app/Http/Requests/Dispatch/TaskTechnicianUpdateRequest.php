<?php

namespace App\Http\Requests\Dispatch;

use Illuminate\Foundation\Http\FormRequest;


/**
 * @OA\Schema(
 *     schema="TaskTechnicianUpdateRequest",
 *     type="object",
 *     title="Task Technician Update Request",
 *     description="Request for updating a technician's assignment details for a task",
 *     required={"date", "start_time", "end_time"},
 *     @OA\Property(
 *         property="date",
 *         type="string",
 *         format="date",
 *         description="Date of the assignment"
 *     ),
 *     @OA\Property(
 *         property="start_time",
 *         type="string",
 *         format="time",
 *         description="Start time of the assignment"
 *     ),
 *     @OA\Property(
 *         property="end_time",
 *         type="string",
 *         format="time",
 *         description="End time of the assignment"
 *     ),
 *     @OA\Property(
 *         property="payment_amount",
 *         type="number",
 *         format="float",
 *         description="Payment amount for the technician",
 *         nullable=true
 *     ),
 *     @OA\Property(
 *         property="paid_at",
 *         type="string",
 *         format="date",
 *         description="Payment date",
 *         nullable=true
 *     ),
 *     @OA\Property(
 *         property="payment_status",
 *         type="string",
 *         description="Payment status",
 *         enum={"paid", "not paid"},
 *         nullable=true
 *     )
 * )
 */
class TaskTechnicianUpdateRequest extends FormRequest
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
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'payment_amount' => 'nullable|numeric',
            'paid_at' => 'nullable|date',
            'payment_status' => 'nullable|in:paid,not paid',
        ];
    }

    public function messages()
    {
        return [
            'date.required' => 'The date is required.',
            'start_time.required' => 'The start time is required.',
            'end_time.required' => 'The end time is required.',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'date' => $this->formatDate($this->date),
            'start_time' => $this->formatTime($this->start_time),
            'end_time' => $this->formatTime($this->end_time),
        ]);
    }

    protected function formatDate($date)
    {
        return date('Y-m-d', strtotime($date));
    }

    protected function formatTime($time)
    {
        return date('H:i', strtotime($time));
    }
}
