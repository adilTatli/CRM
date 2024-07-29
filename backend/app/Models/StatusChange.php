<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="StatusChange",
 *     required={"task_id", "status_id", "user_id"},
 *     @OA\Property(property="id", type="integer", description="Unique identifier of the status change"),
 *     @OA\Property(property="task_id", type="integer", description="ID of the task associated with the status change"),
 *     @OA\Property(property="status_id", type="integer", description="ID of the status that was changed"),
 *     @OA\Property(property="user_id", type="integer", description="ID of the user who made the status change"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Timestamp when the status change was created"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Timestamp when the status change was last updated")
 * )
 */
class StatusChange extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'status_id',
        'user_id',
    ];

    /**
     * @OA\Property(
     *     property="task",
     *     description="The task associated with this status change",
     *     ref="#/components/schemas/Task"
     * )
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * @OA\Property(
     *     property="status",
     *     description="The status that was changed",
     *     ref="#/components/schemas/TaskStatus"
     * )
     */
    public function status()
    {
        return $this->belongsTo(TaskStatus::class);
    }

    /**
     * @OA\Property(
     *     property="user",
     *     description="The user who made the status change",
     *     ref="#/components/schemas/User"
     * )
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
