<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Area",
 *     type="object",
 *     title="Area",
 *     description="Model representing an area",
 *     required={"title"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID of the area"
 *     ),
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         description="Title of the area"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Creation timestamp"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Last update timestamp"
 *     )
 * )
 */
class Area extends Model
{
    use HasFactory;

    protected $fillable = [
        'title'
    ];

    public function schedules()
    {
        return $this->belongsToMany(Schedule::class, 'schedule_technician', 'area_id', 'schedule_id')
            ->withTimestamps();
    }
}
