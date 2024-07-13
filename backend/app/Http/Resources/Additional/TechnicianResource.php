<?php

namespace App\Http\Resources\Additional;

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
            'schedules' => $this->whenLoaded('schedules', function () {
                return $this->schedules->map(function ($schedule) {
                    $areas = $schedule->areas->unique('id')->map(function ($area) {
                        return [
                            'id' => $area->id,
                            'title' => $area->title,
                        ];
                    });

                    return [
                        'id' => $schedule->id,
                        'date' => $schedule->date,
                        'start_time' => $schedule->start_time,
                        'end_time' => $schedule->end_time,
                        'areas' => $areas,
                    ];
                });
            }),
        ];
    }
}
