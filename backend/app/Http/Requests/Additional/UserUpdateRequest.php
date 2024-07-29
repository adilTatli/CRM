<?php

namespace App\Http\Requests\Additional;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UserUpdateRequest",
 *     type="object",
 *     title="UserUpdateRequest",
 *     description="Request body for updating an existing user",
 *     required={"name", "email"},
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Updated name of the user",
 *         example="John Doe"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         description="Updated email address of the user",
 *         example="johndoe@example.com"
 *     ),
 *     @OA\Property(
 *         property="password",
 *         type="string",
 *         format="password",
 *         description="Updated password for the user account (optional)",
 *         example="newstrongpassword123"
 *     )
 * )
 */
class UserUpdateRequest extends FormRequest
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
        $userId = $this->route('user')->id;

        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $userId,
            'password' => 'sometimes|string|min:8',
        ];
    }
}
