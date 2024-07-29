<?php

namespace App\Http\Resources\Additional;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="TechnicianResourceAdditional",
 *     type="object",
 *     description="Technician resource with schedules and areas",
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
 *         description="Email of the technician"
 *     ),
 *     @OA\Property(
 *         property="phone_number",
 *         type="string",
 *         description="Phone number of the technician"
 *     ),
 *     @OA\Property(
 *         property="schedules",
 *         type="array",
 *         description="List of schedules associated with the technician",
 *         @OA\Items(
 *             type="object",
 *             @OA\Property(
 *                 property="id",
 *                 type="integer",
 *                 description="ID of the schedule"
 *             ),
 *             @OA\Property(
 *                 property="date",
 *                 type="string",
 *                 format="date",
 *                 description="Date of the schedule"
 *             ),
 *             @OA\Property(
 *                 property="start_time",
 *                 type="string",
 *                 format="time",
 *                 description="Start time of the schedule"
 *             ),
 *             @OA\Property(
 *                 property="end_time",
 *                 type="string",
 *                 format="time",
 *                 description="End time of the schedule"
 *             ),
 *             @OA\Property(
 *                 property="areas",
 *                 type="array",
 *                 description="List of areas covered in the schedule",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(
 *                         property="id",
 *                         type="integer",
 *                         description="ID of the area"
 *                     ),
 *                     @OA\Property(
 *                         property="title",
 *                         type="string",
 *                         description="Title of the area"
 *                     )
 *                 )
 *             )
 *         )
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
