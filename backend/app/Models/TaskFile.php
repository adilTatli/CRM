<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="TaskFile",
 *     required={"task_id", "file_path", "file_name"},
 *     @OA\Property(property="id", type="integer", description="Unique identifier of the task file"),
 *     @OA\Property(property="task_id", type="integer", description="ID of the task associated with the file"),
 *     @OA\Property(property="file_path", type="string", description="Path to the file in storage"),
 *     @OA\Property(property="file_name", type="string", description="Original name of the file"),
 *     @OA\Property(property="file_note", type="string", description="Optional note related to the file"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Timestamp when the file record was created"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Timestamp when the file record was last updated")
 * )
 */
class TaskFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'file_path',
        'file_name',
        'file_note',
    ];

    /**
     * @OA\Property(
     *     property="task",
     *     description="The task associated with this file",
     *     ref="#/components/schemas/Task"
     * )
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * Handle file upload and save it to the specified storage.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @return array
     */
    public static function handleFileUpload($file): array
    {
        $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
        $filePath = 'task_files/' . date('Y/m/d') . '/';

        if (!file_exists(storage_path('app/public/' . $filePath))) {
            mkdir(storage_path('app/public/' . $filePath), 0755, true);
        }

        // Перемещение файла в хранилище
        $file->move(storage_path('app/public/' . $filePath), $fileName);

        return [
            'file_path' => 'storage/' . $filePath . $fileName,
            'file_name' => $fileName,
        ];
    }
}
