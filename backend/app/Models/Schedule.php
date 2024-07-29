<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Schedule",
 *     required={"date", "start_time", "end_time"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         example=1,
 *         description="Unique identifier of the schedule"
 *     ),
 *     @OA\Property(
 *         property="date",
 *         type="string",
 *         format="date",
 *         example="2024-08-01",
 *         description="Date of the schedule"
 *     ),
 *     @OA\Property(
 *         property="start_time",
 *         type="string",
 *         format="time",
 *         example="09:00",
 *         description="Start time of the schedule in HH:mm format"
 *     ),
 *     @OA\Property(
 *         property="end_time",
 *         type="string",
 *         format="time",
 *         example="17:00",
 *         description="End time of the schedule in HH:mm format"
 *     )
 * )
 */
class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'start_time',
        'end_time',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'schedule_technician', 'schedule_id', 'user_id')
            ->withPivot('area_id')
            ->withTimestamps();
    }

    public function areas()
    {
        return $this->belongsToMany(Area::class, 'schedule_technician', 'schedule_id', 'area_id')
            ->withTimestamps();
    }

    /**
     * Generate date range between start and end dates.
     */
    public static function generateDateRange($startDate, $endDate)
    {
        $dates = [];
        $currentDate = $startDate;

        while ($currentDate <= $endDate) {
            $dates[] = $currentDate;
            $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
        }

        return $dates;
    }

    /**
     * Generate time range between start and end times.
     */
    public static function generateTimeRange($startTime, $endTime)
    {
        $times = [];
        $currentTime = $startTime;

        while ($currentTime <= $endTime) {
            $endTimeObj = date_create_from_format('H:i', $endTime);
            $currentTimeObj = date_create_from_format('H:i', $currentTime);

            if ($currentTimeObj < $endTimeObj) {
                $endTimeObj->modify('-1 minute');
            }

            $times[] = [
                'start' => $currentTime,
                'end' => $endTimeObj->format('H:i')
            ];

            $currentTime = date('H:i', strtotime($currentTime . ' +30 minutes'));
        }

        return $times;
    }
}
