<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="CustomerPhone",
 *     description="Model representing a customer's phone number",
 *     required={"task_id", "phone_number"},
 *     @OA\Property(property="id", type="integer", description="Unique identifier of the customer phone entry"),
 *     @OA\Property(property="task_id", type="integer", description="ID of the task associated with this phone number"),
 *     @OA\Property(property="phone_number", type="string", description="Customer's phone number"),
 *     @OA\Property(property="note", type="string", nullable=true, description="Additional note regarding the phone number"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Timestamp when the entry was created"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Timestamp when the entry was last updated")
 * )
 */
class CustomerPhone extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'phone_number',
        'note',
    ];

    /**
     * Get the task associated with the customer's phone number.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     * @OA\Property(
     *     property="task",
     *     description="The task that this phone number is associated with",
     *     ref="#/components/schemas/Task"
     * )
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
