<?php

namespace App\Http\Resources\Common;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="TaskStatusResourceCommon",
 *     description="Resource representing a task status",
 *     @OA\Property(property="id", type="integer", description="Unique identifier of the task status"),
 *     @OA\Property(property="title", type="string", description="Title of the task status"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Timestamp when the task status was created"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Timestamp when the task status was last updated")
 * )
 */
class TaskStatusResource extends JsonResource
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
            'title' => $this->title,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
