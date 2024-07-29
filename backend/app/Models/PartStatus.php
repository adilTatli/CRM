<?php

namespace App\Models;

use App\Enums\PartStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="PartStatus",
 *     required={"title"},
 *     @OA\Property(property="id", type="integer", description="Unique identifier of the part status"),
 *     @OA\Property(property="title", type="string", description="Title of the part status"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Timestamp when the part status was created"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Timestamp when the part status was last updated")
 * )
 */
class PartStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'title'
    ];

    /**
     * Get all statuses as an array.
     *
     * @return array
     */
    public static function allStatuses()
    {
        return array_map(fn($status) => $status->value, PartStatusEnum::cases());
    }

    /**
     * @OA\Property(
     *     property="parts",
     *     description="The parts associated with this status",
     *     ref="#/components/schemas/Part"
     * )
     */
    public function parts()
    {
        return $this->hasMany(Part::class);
    }
}
