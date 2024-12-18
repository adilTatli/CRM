<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="FileRequest",
 *     type="object",
 *     required={"file"},
 *     @OA\Property(
 *         property="file",
 *         type="string",
 *         format="binary",
 *         description="The file to be uploaded",
 *         example="file.pdf"
 *     ),
 *     @OA\Property(
 *         property="file_note",
 *         type="string",
 *         description="Optional note or description for the file",
 *         maxLength=255,
 *         example="This is a sample file note."
 *     )
 * )
 */
class FileRequest extends FormRequest
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
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'file_note' => 'nullable|string|max:255',
        ];
    }
}
