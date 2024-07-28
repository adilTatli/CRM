<?php

namespace App\Http\Requests\Part;

use Illuminate\Foundation\Http\FormRequest;

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
