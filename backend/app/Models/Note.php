<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Note",
 *     description="Model representing a note attached to a task",
 *     required={"text", "user_id", "task_id"},
 *     @OA\Property(property="id", type="integer", description="Unique identifier of the note"),
 *     @OA\Property(property="text", type="string", description="Text content of the note"),
 *     @OA\Property(property="user_id", type="integer", description="ID of the user who created the note"),
 *     @OA\Property(property="task_id", type="integer", description="ID of the task to which the note is attached"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Timestamp when the note was created"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Timestamp when the note was last updated")
 * )
 */
class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'user_id',
        'task_id',
    ];

    /**
     * Get the task associated with the note.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     * @OA\Property(
     *     property="task",
     *     description="The task that this note is associated with",
     *     ref="#/components/schemas/Task"
     * )
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * Get the user who created the note.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     * @OA\Property(
     *     property="user",
     *     description="The user who created this note",
     *     ref="#/components/schemas/User"
     * )
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
