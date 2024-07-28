<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'file_path',
        'file_name',
        'file_note',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

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
