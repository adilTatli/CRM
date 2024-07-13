<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
