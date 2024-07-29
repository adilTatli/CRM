<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="PartNumber",
 *     description="Model representing part numbers",
 *     required={"title"},
 *     @OA\Property(property="id", type="integer", description="Unique identifier of the part number"),
 *     @OA\Property(property="title", type="string", description="Title or name of the part number"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Timestamp when the part number was created"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Timestamp when the part number was last updated")
 * )
 */
class PartNumber extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
    ];

    /**
     * @OA\Property(
     *     property="parts",
     *     description="The parts associated with this part number",
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/Part")
     * )
     */
    public function parts()
    {
        return $this->hasMany(Part::class);
    }
}
