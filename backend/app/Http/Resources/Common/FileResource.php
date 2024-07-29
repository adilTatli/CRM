<?php

namespace App\Http\Resources\Common;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="FileResource",
 *     type="object",
 *     required={"id", "file_path", "file_name"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="Unique identifier for the file",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="file_path",
 *         type="string",
 *         description="Path where the file is stored",
 *         example="/uploads/files/example.pdf"
 *     ),
 *     @OA\Property(
 *         property="file_name",
 *         type="string",
 *         description="Name of the file",
 *         example="example.pdf"
 *     ),
 *     @OA\Property(
 *         property="file_note",
 *         type="string",
 *         description="Additional notes or description about the file",
 *         example="This file contains the signed agreement"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Timestamp when the file record was created",
 *         example="2024-07-25T15:00:00Z"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Timestamp when the file record was last updated",
 *         example="2024-07-26T15:00:00Z"
 *     )
 * )
 */
class FileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'file_path' => $this->file_path,
            'file_name' => $this->file_name,
            'file_note' => $this->file_note,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
