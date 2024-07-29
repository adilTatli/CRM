<?php

namespace App\Http\Resources\Dispatch;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="TechnicianResourceDispatch",
 *     type="object",
 *     title="Technician Resource",
 *     description="Details of a technician",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID of the technician"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Name of the technician"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         description="Email address of the technician"
 *     ),
 *     @OA\Property(
 *         property="phone_number",
 *         type="string",
 *         description="Phone number of the technician"
 *     ),
 *     @OA\Property(
 *         property="schedules",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/ScheduleResourceDispatch"),
 *         description="List of schedules assigned to the technician"
 *     ),
 *     @OA\Property(
 *         property="tasks",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/TaskTechnicianResourceDispatch"),
 *         description="List of tasks assigned to the technician"
 *     )
 * )
 */
class TechnicianResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'schedules' => ScheduleResource::collection($this->whenLoaded('schedules')),
            'tasks' => TaskTechnicianResource::collection($this->whenLoaded('tasks')),
        ];
    }
}
