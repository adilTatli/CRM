<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Appliance",
 *     type="object",
 *     title="Appliance",
 *     description="Model representing an appliance",
 *     required={"title"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID of the appliance"
 *     ),
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         description="Title of the appliance"
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
class Appliance extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
    ];

    public function applianceLists()
    {
        return $this->hasMany(ApplianceList::class);
    }

    public function parts()
    {
        return $this->hasMany(Part::class);
    }
}
