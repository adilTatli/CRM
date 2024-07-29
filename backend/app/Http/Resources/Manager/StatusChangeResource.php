<?php

namespace App\Http\Resources\Manager;

use App\Http\Resources\Common\TaskStatusResource;
use App\Http\Resources\Common\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="StatusChangeResourceManager",
 *     description="Resource representing a status change",
 *     @OA\Property(property="id", type="integer", description="Unique identifier of the status change"),
 *     @OA\Property(property="task_id", type="integer", description="Identifier of the associated task"),
 *     @OA\Property(property="status", ref="#/components/schemas/TaskStatusResourceCommon", description="The status associated with this change"),
 *     @OA\Property(property="user", ref="#/components/schemas/UserResourceCommon", description="The user who made the status change"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Timestamp when the status change was recorded")
 * )
 */
class StatusChangeResource extends JsonResource
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
            'task_id' => $this->task_id,
            'status' => new TaskStatusResource($this->whenLoaded('status')),
            'user' => new UserResource($this->whenLoaded('user')),
            'created_at' => $this->created_at,
        ];
    }
}
