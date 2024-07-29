<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Distributor",
 *     required={"id", "title"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="Distributor's ID"
 *     ),
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         description="Distributor's name",
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
class Distributor extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
    ];

    public function parts()
    {
        return $this->hasMany(Part::class);
    }
}
