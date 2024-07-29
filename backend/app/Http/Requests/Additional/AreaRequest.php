<?php

namespace App\Http\Requests\Additional;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="AreaRequest",
 *     type="object",
 *     title="AreaRequest",
 *     description="Request payload for creating or updating an area",
 *     required={"title"},
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         description="Title of the area"
 *     )
 * )
 */
class AreaRequest extends FormRequest
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
