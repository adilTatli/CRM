<?php

namespace App\Http\Resources\Additional;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

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
