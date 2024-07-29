<?php

namespace App\Http\Requests\Additional;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="InsuranceRequest",
 *     required={"title"},
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         description="Insurance's name",
 *         example="ACME Supplies"
 *     )
 * )
 */
class InsuranceRequest extends FormRequest
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
            'title' => 'required|string|max:255',
        ];
    }
}
