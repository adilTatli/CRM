<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="ApplianceList",
 *     description="Model representing an appliance list entry",
 *     required={"serial_number", "model_number", "brand", "appliance_id", "task_id"},
 *     @OA\Property(property="id", type="integer", description="Unique identifier of the appliance list entry"),
 *     @OA\Property(property="serial_number", type="string", description="Serial number of the appliance"),
 *     @OA\Property(property="model_number", type="string", description="Model number of the appliance"),
 *     @OA\Property(property="brand", type="string", description="Brand of the appliance"),
 *     @OA\Property(property="dop", type="string", format="date", nullable=true, description="Date of purchase"),
 *     @OA\Property(property="appl_note", type="string", nullable=true, description="Additional note about the appliance"),
 *     @OA\Property(property="appliance_id", type="integer", description="ID of the appliance type"),
 *     @OA\Property(property="task_id", type="integer", description="ID of the task associated with this appliance"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Timestamp when the entry was created"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Timestamp when the entry was last updated")
 * )
 */
class ApplianceList extends Model
{
    use HasFactory;

    protected $fillable = [
        'serial_number',
        'model_number',
        'brand',
        'dop',
        'appl_note',
        'appliance_id',
        'task_id',
    ];

    /**
     * Get the task associated with the appliance.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     * @OA\Property(
     *     property="task",
     *     description="The task that this appliance is associated with",
     *     ref="#/components/schemas/Task"
     * )
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * Get the appliance type of the appliance.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     * @OA\Property(
     *     property="appliance",
     *     description="The type of appliance",
     *     ref="#/components/schemas/Appliance"
     * )
     */
    public function appliance()
    {
        return $this->belongsTo(Appliance::class);
    }
}
