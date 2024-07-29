<?php

namespace App\Models;

use App\Enums\TaskStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="TaskStatus",
 *     description="Model representing status of a task",
 *     required={"title"},
 *     @OA\Property(property="id", type="integer", description="Unique identifier of the status"),
 *     @OA\Property(property="title", type="string", description="Title of the status"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Timestamp when the status was created"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Timestamp when the status was last updated")
 * )
 */
class TaskStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'title'
    ];

    /**
     * Get all statuses defined in the TaskStatusEnum.
     *
     * @return array
     */
    public static function allStatuses()
    {
        return array_map(fn($status) => $status->value, TaskStatusEnum::cases());
    }

    /**
     * Get the tasks associated with the status.
     *
     * @OA\Property(
     *     property="tasks",
     *     description="Tasks associated with this status",
     *     ref="#/components/schemas/Task"
     * )
     */
    public function tasks()
    {
        return $this->HasMany(Task::class);
    }

    /**
     * Get the status changes associated with the status.
     *
     * @OA\Property(
     *     property="statusChanges",
     *     description="Changes related to this status",
     *     ref="#/components/schemas/StatusChange"
     * )
     */
    public function statusChanges()
    {
        return $this->hasMany(StatusChange::class, 'status_id');
    }
}
