<?php

namespace App\Http\Resources\Dispatch;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
