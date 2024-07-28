<?php

namespace App\Http\Resources\Dispatch;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleResource extends JsonResource
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
            'date' => $this->date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'areas' => $this->whenLoaded('areas', function () {
                return $this->areas->map(function ($area) {
                    return [
                        'id' => $area->id,
                        'title' => $area->title,
                    ];
                });
            }),
        ];
    }
}
