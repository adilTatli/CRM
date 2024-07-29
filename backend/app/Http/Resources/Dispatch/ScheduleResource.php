<?php

namespace App\Http\Resources\Dispatch;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="ScheduleResourceDispatch",
 *     type="object",
 *     title="Schedule Resource",
 *     description="Schedule details for a specific task",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID of the schedule"
 *     ),
 *     @OA\Property(
 *         property="date",
 *         type="string",
 *         format="date",
 *         description="Date of the schedule"
 *     ),
 *     @OA\Property(
 *         property="start_time",
 *         type="string",
 *         format="time",
 *         description="Start time of the schedule"
 *     ),
 *     @OA\Property(
 *         property="end_time",
 *         type="string",
 *         format="time",
 *         description="End time of the schedule"
 *     ),
 *     @OA\Property(
 *         property="areas",
 *         type="array",
 *         @OA\Items(
 *             @OA\Property(property="id", type="integer", description="ID of the area"),
 *             @OA\Property(property="title", type="string", description="Title of the area")
 *         ),
 *         description="List of areas associated with the schedule",
 *         nullable=true
 *     )
 * )
 */
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
