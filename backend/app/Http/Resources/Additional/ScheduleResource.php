<?php

namespace App\Http\Resources\Additional;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

/**
 * @OA\Schema(
 *     schema="ScheduleResourceAdditional",
 *     type="object",
 *     @OA\Property(property="id", type="integer", description="ID of the schedule"),
 *     @OA\Property(property="date", type="string", format="date", description="Date of the schedule"),
 *     @OA\Property(property="start_time", type="string", format="time", description="Start time of the schedule"),
 *     @OA\Property(property="end_time", type="string", format="time", description="End time of the schedule"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Creation timestamp"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Update timestamp"),
 *     @OA\Property(
 *         property="users",
 *         type="array",
 *         @OA\Items(
 *             type="object",
 *             @OA\Property(property="id", type="integer", description="ID of the user"),
 *             @OA\Property(property="name", type="string", description="Name of the user"),
 *             @OA\Property(property="email", type="string", description="Email of the user"),
 *             @OA\Property(property="phone_number", type="string", description="Phone number of the user"),
 *             @OA\Property(
 *                 property="areas",
 *                 type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="id", type="integer", description="ID of the area"),
 *                     @OA\Property(property="title", type="string", description="Title of the area")
 *                 )
 *             )
 *         )
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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'users' => $this->users->map(function ($user) {
                $areas = DB::table('schedule_technician')
                    ->join('areas', 'schedule_technician.area_id', '=', 'areas.id')
                    ->where('schedule_technician.user_id', $user->id)
                    ->where('schedule_technician.schedule_id', $this->id)
                    ->select('areas.id', 'areas.title')
                    ->get();

                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone_number' => $user->phone_number,
                    'areas' => $areas->map(function ($area) {
                        return [
                            'id' => $area->id,
                            'title' => $area->title,
                        ];
                    }),
                ];
            }),
        ];
    }
}
