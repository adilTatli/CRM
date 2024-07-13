<?php

namespace App\Http\Requests\Additional;

use Illuminate\Foundation\Http\FormRequest;

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
