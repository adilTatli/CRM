<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

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
