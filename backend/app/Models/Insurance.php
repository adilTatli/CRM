<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Insurance",
 *     required={"id", "title"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="Insurance's ID"
 *     ),
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         description="Insurance's name",
 *         example="ACME Supplies"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Date and time of creation"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Date and time of the last update"
 *     )
 * )
 */
class Insurance extends Model
{
    use HasFactory;

    protected $fillable = [
        'title'
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
